<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;


use App\Models\User;
use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Nwidart\Modules\Routing\Controller;
use Modules\Reminder\app\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Modules\Reminder\app\Models\Reminder;
use Modules\PotentialCustomer\app\Models\Country;
use Modules\PotentialCustomer\app\Models\LeadType;
use Modules\PotentialCustomer\app\Models\LeadValue;
use Modules\PotentialCustomer\app\Models\LeadSource;
use Modules\PotentialCustomer\app\Models\LeadStatus;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\Reminder\app\Http\Requests\ReminderRequest;
use Modules\PotentialCustomer\app\Models\LeadTransition;
use Modules\PotentialCustomer\app\Exports\InvalidRowExport;
use Modules\PotentialCustomer\app\Models\LeadAccountImport;
use Modules\PotentialCustomer\app\Models\ImportDataInvalidRow;
use Modules\PotentialCustomer\app\Imports\LeadAccountDataImport;
use Modules\PotentialCustomer\app\DataTables\LeadAccountDataTable;
use Modules\PotentialCustomer\app\Exports\NewDataLeadAccountExport;
use Modules\PotentialCustomer\app\Http\Requests\LeadAccountRequest;
use Modules\Reminder\app\Http\Controllers\Dashboard\ReminderController;


class LeadAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadAccountDataTable $dataTable)
    {
        $leadSources = LeadSource::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadStatuses = LeadStatus::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadValues = LeadValue::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadTypes = LeadType::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();

        $salesAgents = User::select('id', 'name')->role('sales')->where('status', 'active')->where('created_by', auth()->id())->get();
        return $dataTable->render('potentialcustomer::pages.leads.lead_account.index', compact('leadStatuses', 'leadValues', 'leadSources', 'leadTypes', 'salesAgents'));
    }

    /*     public function filter(LeadAccountDataTable $dataTable,LeadAccount $leadAccount)
        {
            $data =  DataTables::of($dataTable->query($leadAccount)
            ->where('condition', 'lead')
            ->where('created_by', auth()->id())
            ->orderBy('id', 'asc'))
            ->filter(function ($query) {
                if (request()->filled('lead_source_id')) {
                    $query->where('lead_source_id', request()->input('lead_source_id'));
                }
                if (request()->filled('lead_status_id')) {
                    $query->where('lead_status_id', request()->input('lead_status_id'));
                }
                if (request()->filled('lead_value_id')) {
                    $query->where('lead_value_id', request()->input('lead_value_id'));
                }
            })->toJson();
            return response()->json([
                'success'=>true,
                'data'=>$data
            ]);
        } */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leadSources = LeadSource::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadStatuses = LeadStatus::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadValues = LeadValue::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadTypes = LeadType::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $countries = Country::where('status', 'active')->pluck('name', 'id')->toArray();
        $salesAgents = User::select('id', 'name')->where('status', 'active')->where('created_by', auth()->id())->role('sales')->get();

        return view('potentialcustomer::pages.leads.lead_account.create_edit', compact('leadSources', 'leadStatuses', 'leadValues', 'leadTypes', 'countries', 'salesAgents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadAccountRequest $request)
    {
        $image = NULL;
        if ($request->has('image')) {
            $image = Storage::putFile("lead_account/images", $request->image);
        }

        LeadAccount::create([
            "image" => $image,
            "account_name" => $request->account_name,
            'account_contact_name' => $request->account_contact_name,
            "lead_account_title" => $request->lead_account_title,
            "email" => $request->email,
            "website" => $request->website,
            'sales_agent_id' => $request->sales_agent_id,
            "personal_number" => str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->personal_number),
            "mobile" => str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->mobile),
            "phone" => str_replace(['+', '(', ')', ' ', '-', '.'], '',  $request->phone),
            'created_as' => 'lead',
            "lead_source_id" => $request->lead_source_id,
            "lead_status_id" => $request->lead_status_id,
            "lead_value_id" => $request->lead_value_id,
            "lead_type_id" => $request->lead_type_id,
            /* "country_id" => $request->country_id,
            "state_id" => $request->state_id, */
            "city_id" => $request->city_id,
            "zip_code" => $request->zip_code,
            "address" => $request->address,
            "notes" => $request->notes,
            "status" => $request->status,
            'created_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Lead Account  Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadAccount $leadAccount)
    {
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminders = $leadAccount->reminders()->where('status', 'active')->orderby('reminder_end_date', 'ASC')->paginate(3);
        return view('potentialcustomer::pages.leads.lead_account.show', compact('leadAccount', 'reminders', 'contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadAccount $leadAccount)
    {
        $salesAgents = User::select('id', 'name')->where('status', 'active')->where('created_by', auth()->id())->role('sales')->get();
        $leadSources = LeadSource::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadStatuses = LeadStatus::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadTypes = LeadType::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadValues = LeadValue::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $countries = Country::where('status', 'active')->pluck('name', 'id')->toArray();

        return view('potentialcustomer::pages.leads.lead_account.create_edit', compact('leadAccount', 'leadSources', 'leadStatuses', 'leadTypes', 'salesAgents', 'leadValues', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadAccountRequest $request, LeadAccount $leadAccount)
    {
        $image = NULL;
        if ($request->has('image')) {
            if ($leadAccount->image) {
                Storage::delete($leadAccount->image);
            }
            $image = Storage::putFile("lead_account/images", $request->image);
        }


        $leadAccount->update([
            "image" => $image,
            "account_name" => $request->account_name,
            'account_contact_name' => $request->account_contact_name,
            "lead_account_title" => $request->lead_account_title,
            "email" => $request->email,
            "website" => $request->website,
            "personal_number" => str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->personal_number),
            "mobile" => str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->mobile),
            "phone" => str_replace(['+', '(', ')', ' ', '-', '.'], '',  $request->phone),
            "lead_source_id" => $request->lead_source_id,
            "lead_status_id" => $request->lead_status_id,
            "lead_value_id" => $request->lead_value_id,
            "lead_type_id" => $request->lead_type_id,
            'sales_agent_id' => $request->sales_agent_id,
            /* "country_id" => $request->country_id,
            "state_id" => $request->state_id, */
            "city_id" => $request->city_id,
            "zip_code" => $request->zip_code,
            "address" => $request->address,
            "notes" => $request->notes,
            "status" => $request->status,
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Lead Account  Edited Successfully'));
        return redirect()->route('lead_account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadAccount $leadAccount)
    {
        $leadAccount->update([
            'deleted_by' => auth()->id(),
        ]);
        if ($leadAccount->image) {
            Storage::delete($leadAccount->image);
        }
        $leadAccount->delete();
        Alert::success(__('Success'), __('Lead Account  deleted Successfully'));
    }
    public function potentialTransition(LeadAccount $leadAccount)
    {
        $leadAccount->update([
            'condition' => 'potential',
            'updated_by' => auth()->id(),
        ]);

        LeadTransition::create([
            'account_id' => $leadAccount->id,
            'to_potential_account' => TRUE,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('This Lead Account became Potential Account Successfully'));
    }
    public function editReminderPage($reminderId, $leadAccountId)
    {
        $leadAccount = LeadAccount::findOrFail($leadAccountId);
        $reminder = Reminder::findOrFail($reminderId);
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminderContacts = $reminder->contacts;
        return view('potentialcustomer::pages.leads.lead_account.edit-reminder', compact('reminder', 'leadAccount', 'contacts', 'reminderContacts'));
    }
    public function updateCustomerReminder(ReminderRequest $request, Reminder $reminder, LeadAccount $leadAccount)
    {
        ReminderController::updateReminder($request, $reminder);
        Alert::success(__('Success'), __('Reminder Updated Successfully'));
        return redirect()->route('lead_account.show', ['lead_account' => $leadAccount]);
    }


    public function changeSelectedRows(Request $request)
    {
        foreach ($request->lead_account_ids as $leadAccountId) {
            $leadAccount = LeadAccount::findOrFail($leadAccountId);

            if (!empty($request->lead_source_id)) {
                $leadAccount->update(['lead_source_id' => $request->lead_source_id]);
            }
            if (!empty($request->lead_status_id)) {
                $leadAccount->update(['lead_status_id' => $request->lead_status_id]);
            }
            if (!empty($request->lead_value_id)) {
                $leadAccount->update(['lead_value_id' => $request->lead_value_id]);
            }
            if (!empty($request->lead_type_id)) {
                $leadAccount->update(['lead_type_id' => $request->lead_type_id]);
            }
            if (!empty($request->sales_agent_id)) {
                $leadAccount->update(['sales_agent_id' => $request->sales_agent_id]);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function activate(LeadAccount $leadAccount)
    {
        $leadAccount->update([
            'status' => 'active',
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('This Lead Account Activated Successfully'));
    }

    /*  -------------------- Import Functions ------------------------ */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt,xlsx,xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:' . Helpers::return_bytes(ini_get('upload_max_filesize')),
        ]);
        Session::put('inserted', false);
        LeadAccountImport::where('created_by', auth()->id())->where('created_as', 'lead')->delete();
        ImportDataInvalidRow::where('created_by', auth()->id())->where('model', 'lead_account')->delete();
        if ($validator->fails()) {
            $messages = '';
            foreach ($validator->errors()->all() as $error) {
                $messages .= $error . ' ';
            }
            return response()->json(['success' => false, 'message' => $messages]);
        } else {
            $file = $request->file('file');
            $fileDataArray = Helpers::uploadFile($file, 'lead_accounts');
            $headings = (new HeadingRowImport)->toArray(public_path($fileDataArray['file_dir'] . $fileDataArray['file_name'])); // set csv path here or
            $match_columns = $headings[0][0];

            Session::put('fileColumns', $match_columns);
            Session::put('fileDataArray', json_encode($fileDataArray));
            return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('lead_account.matchColumns')]);
        }
    }

    public function matchColumns()
    {


        if (Session::get('inserted') == true) {
            return redirect()->route('lead_account.index');
        }
        $fileColumns = Session::get('fileColumns');
        if (file_exists(base_path('/Modules/PotentialCustomer/resources/views/pages/leads/lead_account/match_import.blade.php'))) {
            $tableColumns = [
                'Account Name' => 'account_name',
                'Account contact name' => 'account_contact_name',
                'Lead Account Title' => 'lead_account_title',
                'Personal Number' => 'personal_number',
                'Phone' => 'phone',
                'Mobile' => 'mobile',
                'Email' => 'email',
                'Website' => 'website',
                'Address' => 'address',
                'notes' => 'notes',
                'Zip Code' => 'zip_code',
            ];

            $compact = compact('fileColumns', 'tableColumns');
            Session::put('lead_accounts_progress', 0);
            return view('potentialcustomer::pages.leads.lead_account.match_import', $compact);
        }
    }


    public function matchColumnUpdate(Request $request)
    {
        Session::put('inserted', true);
        Session::put('fails_rows_array_with_errors', null);
        $match_columns = [];
        foreach (json_decode($request->columns) as $key => $value) {
            if ($value) {
                $match_columns[strtolower($key)] = strtolower($value);
            }
        }
        $file = json_decode(Session::get('fileDataArray'));
        Session::put('lead_accounts_progress', 0);
        Excel::import(new LeadAccountDataImport($match_columns), public_path($file->file_dir . $file->file_name));
        return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('lead_account.getImportedData')]);
    }
    public function getImportedData()
    {
        $duplicated_leadAccounts = LeadAccountImport::where('created_by', auth()->id())
            ->where('created_as', 'lead')
            ->where('is_new', 0)
            ->where('has_changes', 0)
            ->get();

        $changed_leadAccounts = LeadAccountImport::where('created_by', auth()->id())
            ->where('created_as', 'lead')
            ->where('is_new', 0)
            ->where('has_changes', 1)
            ->get();

        $leadAccounts = LeadAccountImport::where('created_by', auth()->id())->where('is_new', 1)
            ->where('created_as', 'lead')->get();

        if (!empty(Session::get('fails_rows_array_with_errors'))) {
            $fails_rows_array_with_errors = Session::get('fails_rows_array_with_errors');
        } else {
            $fails_rows_array_with_errors = [];
        }

        return view('potentialcustomer::pages.leads.lead_account.mapping_data', compact('leadAccounts', 'fails_rows_array_with_errors', 'changed_leadAccounts', 'duplicated_leadAccounts'));
    }
    /*  -------------------- Export Functions ------------------------ */


    public function insertNewData()
    {

        $new_collected_data = LeadAccountImport::where('created_by', auth()->id())->where('created_as', 'lead')->where('is_new', 1)->get();
        foreach ($new_collected_data as $row) {
            LeadAccount::create([
                'account_name' => $row->account_name,
                'account_contact_name' => $row->account_contact_name,
                'lead_account_title' => $row->lead_account_title,
                'personal_number' => $row->personal_number,
                'phone' => $row->phone,
                'mobile' => $row->mobile,
                'email' => $row->email,
                'website' => $row->website,
                'address' => $row->address,
                'notes' => $row->notes,
                'zip_code' => $row->zip_code,
                'created_as' => 'lead',
                'condition' => 'lead',
                'created_by' => auth()->id(),
            ]);
        }
        Alert::success(__('Success'), __('Lead Account Data inserted Successfully'));
        return redirect()->route('lead_account.index');
    }
    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $leadAccounts = LeadAccount::where('condition', 'lead')->where('created_by', auth()->id())->get();
        } else {
            $leadAccounts = LeadAccount::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'lead_account',$leadAccounts,$columns);
    }


    public function exportNewData()
    {
        $fileName = 'new_data_before_insert_lead_accounts' . '_' . date('Y-m-d') . '.xlsx';
        $leadAccounts = LeadAccountImport::where('condition', 'lead')->where('created_by', auth()->id())->get();
        return Excel::download(new NewDataLeadAccountExport($leadAccounts), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportInvalidRows()
    {
        $fileName = 'invalid-collected-data-rows-' . today() . '.xlsx';
        $invalidDate = ImportDataInvalidRow::where('created_by', auth()->id())->where('model', 'lead_account')->get();
        $export = new InvalidRowExport($invalidDate);
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
