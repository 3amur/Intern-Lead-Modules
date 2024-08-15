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
use Modules\PotentialCustomer\app\Models\Link;
use Modules\PotentialCustomer\app\Models\Country;
use Modules\PotentialCustomer\app\Models\LeadType;
use Modules\PotentialCustomer\app\Models\LeadValue;
use Modules\PotentialCustomer\app\Models\LeadSource;
use Modules\PotentialCustomer\app\Models\LeadStatus;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\Reminder\app\Http\Requests\ReminderRequest;
use Modules\PotentialCustomer\app\Models\LeadTransition;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\Exports\InvalidRowExport;
use Modules\PotentialCustomer\app\Models\LeadAccountImport;
use Modules\PotentialCustomer\app\Exports\LeadAccountExport;
use Modules\PotentialCustomer\app\Models\ImportDataInvalidRow;
use Modules\PotentialCustomer\app\Models\PotentialAccountDetails;
use Modules\PotentialCustomer\app\Imports\PotentialAccountDataImport;
use Modules\Reminder\app\Http\Controllers\Dashboard\ReminderController;
use Modules\PotentialCustomer\app\DataTables\PotentialAccountsDataTable;
use Modules\PotentialCustomer\app\Exports\NewDataPotentialAccountExport;
use Modules\PotentialCustomer\app\Http\Requests\PotentialAccountRequest;
use Modules\PotentialCustomer\app\Exports\PotentialAccountsImportInvalidRowExport;

class PotentialAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PotentialAccountsDataTable $dataTable)
    {
        $links = Link::where('created_by', auth()->id())->get();
        $leadSources = LeadSource::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadStatuses = LeadStatus::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadValues = LeadValue::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadTypes = LeadType::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();

        $salesAgents = User::select('id', 'name')->role('sales')->where('status', 'active')->where('created_by', auth()->id())->get();
        return $dataTable->render('potentialcustomer::pages.leads.potential_account.index', compact('links', 'leadStatuses', 'leadValues','leadTypes' ,'leadSources', 'salesAgents'));
    }

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
        return view('potentialcustomer::pages.leads.potential_account.create_edit', compact('leadSources', 'leadStatuses', 'leadValues', 'leadTypes', 'countries', 'salesAgents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PotentialAccountRequest $request)
    {
        $request->merge([
            'potential_premium' => floatval(str_replace(',', '', $request->potential_premium)),
            'price_range_min' => floatval(str_replace(',', '', $request->price_range_min)),
            'price_range_max' => floatval(str_replace(',', '', $request->price_range_max)),
        ]);
        $image = NULL;

        if ($request->has('image')) {
            $image = Storage::putFile("lead_account/images", $request->image);
        }

        $potentialAccount = LeadAccount::create([
            "image" => $image,
            "account_name" => $request->account_name,
            'account_contact_name' => $request->account_contact_name,
            "lead_account_title" => $request->lead_account_title,
            "email" => $request->email,
            "website" => $request->website,
            "personal_number" =>str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->personal_number),
            "mobile" =>str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->mobile),
            "phone" =>str_replace(['+', '(', ')', ' ', '-', '.'], '',  $request->phone),
            'condition' => 'potential',
            'created_as' => 'potential',
            "lead_source_id" => $request->lead_source_id,
            "lead_status_id" => $request->lead_status_id,
            "lead_value_id" => $request->lead_value_id,
            "lead_type_id" => $request->lead_type_id,
            "city_id" => $request->city_id,
            "zip_code" => $request->zip_code,
            "address" => $request->address,
            "notes" => $request->notes,
            "status" => $request->status,
            'created_by' => auth()->id(),
        ]);

        if ($potentialAccount) {
            PotentialAccountDetailsController::updateDetails($request, $potentialAccount->potentialAccountDetails);
        }
        Alert::success(__('Success'), __('Potential Account  Created Successfully'));
        return redirect()->route('potential_account.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadAccount $potentialAccount)
    {
        $links = $potentialAccount->links;
        $headMembers = $potentialAccount->headMembers;
        $collectedData = $potentialAccount->importedData()->paginate(15);
        $potentialAccountDetails = $potentialAccount->potentialAccountDetails;
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminders = $potentialAccount->reminders()->where('status', 'active')->orderby('reminder_end_date', 'ASC')->paginate(5);

        return view('potentialcustomer::pages.leads.potential_account.show', compact('potentialAccount', 'links', 'headMembers', 'reminders','contacts','collectedData', 'potentialAccountDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadAccount $potentialAccount)
    {
        $leadSources = LeadSource::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadStatuses = LeadStatus::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadValues = LeadValue::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $leadTypes = LeadType::select('id', 'title')->where('status', 'active')->where('created_by', auth()->id())->get();
        $countries = Country::where('status', 'active')->pluck('name', 'id')->toArray();
        $salesAgents = User::select('id', 'name')->where('status', 'active')->where('created_by', auth()->id())->role('sales')->get();
        $potentialAccountDetails = $potentialAccount->potentialAccountDetails;

        return view('potentialcustomer::pages.leads.potential_account.create_edit', compact('potentialAccount', 'leadSources', 'potentialAccountDetails', 'leadStatuses', 'leadTypes', 'leadValues', 'countries', 'salesAgents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PotentialAccountRequest $request, LeadAccount $potentialAccount)
    {
        $request->merge([
            'potential_premium' => floatval(str_replace(',', '',request('potential_premium'))),
            'price_range_min' => floatval(str_replace(',', '', request('price_range_min'))),
            'price_range_max' => floatval(str_replace(',', '', request('price_range_max'))),
        ]);
        $image = NULL;

        if ($request->has('image')) {
            if ($potentialAccount->image) {
                Storage::delete($potentialAccount->image);
            }
            $image = Storage::putFile("lead_account/images", $request->image);
        }
        $potentialAccount->update([
            "image" => $image,
            "account_name" => $request->account_name,
            'account_contact_name' => $request->account_contact_name,
            "lead_account_title" => $request->lead_account_title,
            "email" => $request->email,
            "website" => $request->website,
            "personal_number" =>str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->personal_number),
            "mobile" =>str_replace(['+', '(', ')', ' ', '-', '.'], '', $request->mobile),
            "phone" =>str_replace(['+', '(', ')', ' ', '-', '.'], '',  $request->phone),
            "lead_source_id" => $request->lead_source_id,
            "lead_status_id" => $request->lead_status_id,
            "lead_value_id" => $request->lead_value_id,
            "lead_type_id" => $request->lead_type_id,
            "city_id" => $request->city_id,
            "zip_code" => $request->zip_code,
            "address" => $request->address,
            "notes" => $request->notes,
            "status" => $request->status,
            'updated_by' => auth()->id(),
        ]);
        if ($potentialAccount) {
            PotentialAccountDetailsController::updateDetails($request, $potentialAccount->potentialAccountDetails);
        }
        Alert::success(__('Success'), __('Potential Account  Edited Successfully'));
        return redirect()->route('potential_account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadAccount $potentialAccount)
    {
        $potentialAccount->update([
            'deleted_by' => auth()->id(),
        ]);
        if ($potentialAccount->image) {
            Storage::delete($potentialAccount->image);
        }
        $potentialAccount->delete();
        Alert::success(__('Success'), __('Potential Account Edited Successfully'));
    }

    public function leadTransition(LeadAccount $potentialAccount)
    {
        $potentialAccount->update([
            'condition' => 'lead',
            'updated_by' => auth()->id(),
        ]);

        LeadTransition::create([
            'account_id' => $potentialAccount->id,
            'to_lead_account' => true,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Potential Account became Lead Account Successfully'));
    }

    public function activate(LeadAccount $potentialAccount)
    {
        $potentialAccount->update([
            'status' => 'active',
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('This Potential Customer Activated Successfully'));
    }

    public function editReminderPage($reminderId, $potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        $reminder = Reminder::findOrFail($reminderId);
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminderContacts = $reminder->contacts;
        return view('potentialcustomer::pages.leads.potential_account.edit-reminder', compact('reminder', 'potentialAccount', 'contacts', 'reminderContacts'));
    }
    public function updateCustomerReminder(ReminderRequest $request, Reminder $reminder, LeadAccount $potentialAccount)
    {
        ReminderController::updateReminder($request, $reminder);
        Alert::success(__('Success'), __('Reminder Updated Successfully'));
        return redirect()->route('potential_account.show', ['potential_account' => $potentialAccount]);
    }


    //TODO:: Need To be More Clean With DRY Concept -- there is same function in LeadAccountController
    public function changeSelectedRows(Request $request)
    {
        foreach ($request->potentialAccountsIds as $potentialAccountId) {
            $PotentialAccount = LeadAccount::findOrFail($potentialAccountId);

            if (!empty($request->lead_source_id)) {
                $PotentialAccount->update(['lead_source_id' => $request->lead_source_id]);
            }
            if (!empty($request->lead_status_id)) {
                $PotentialAccount->update(['lead_status_id' => $request->lead_status_id]);
            }
            if (!empty($request->lead_value_id)) {
                $PotentialAccount->update(['lead_value_id' => $request->lead_value_id]);
            }
            if (!empty($request->lead_type_id)) {
                $PotentialAccount->update(['lead_type_id' => $request->lead_type_id]);
            }
            if (!empty($request->sales_agent_id)) {
                $PotentialAccount->update(['sales_agent_id' => $request->sales_agent_id]);
            }
        }
        return response()->json([
            'success' => true,
        ]);

    }

    /*  -------------------- Import Functions ------------------------ */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt,xlsx,xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:' . Helpers::return_bytes(ini_get('upload_max_filesize')),
        ]);
        Session::put('inserted', false);
        LeadAccountImport::where('created_by', auth()->id())->where('created_as', 'potential')->delete();
        ImportDataInvalidRow::where('created_by', auth()->id())->where('model', 'potential_account')->delete();
        if ($validator->fails()) {
            $messages = '';
            foreach ($validator->errors()->all() as $error) {
                $messages .= $error . ' ';
            }
            return response()->json(['success' => false, 'message' => $messages]);
        } else {
            $file = $request->file('file');
            $fileDataArray = Helpers::uploadFile($file, 'potential_accounts');
            $headings = (new HeadingRowImport)->toArray(public_path($fileDataArray['file_dir'] . $fileDataArray['file_name'])); // set csv path here or
            $match_columns = $headings[0][0];

            Session::put('fileColumns', $match_columns);
            Session::put('fileDataArray', json_encode($fileDataArray));
            return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('potential_account.matchColumns')]);
        }
    }

    public function matchColumns()
    {

        if (Session::get('inserted') == true) {
            return redirect()->route('potential_account.index');
        }
        $fileColumns = Session::get('fileColumns');
        if (file_exists(base_path('/Modules/PotentialCustomer/resources/views/pages/leads/potential_account/match_import.blade.php'))) {
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
            Session::put('potential_accounts_progress', 0);
            return view('potentialcustomer::pages.leads.potential_account.match_import', $compact);
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
        Session::put('potential_accounts_progress', 0);
        Excel::import(new PotentialAccountDataImport($match_columns), public_path($file->file_dir . $file->file_name));
        return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('potential_account.getImportedData')]);


    }
    public function getImportedData()
    {
        $duplicated_potentialAccounts = LeadAccountImport::where('created_by', auth()->id())
            ->where('created_as', 'potential')
            ->where('is_new', 0)
            ->where('has_changes', 0)
            ->get();

        $changed_potentialAccounts = LeadAccountImport::where('created_by', auth()->id())
            ->where('created_as', 'potential')
            ->where('is_new', 0)
            ->where('has_changes', 1)
            ->get();

        $potentialAccounts = LeadAccountImport::where('created_by', auth()->id())->where('is_new', 1)
            ->where('created_as', 'potential')->get();

        if (!empty(Session::get('fails_rows_array_with_errors'))) {
            $fails_rows_array_with_errors = Session::get('fails_rows_array_with_errors');
        } else {
            $fails_rows_array_with_errors = [];
        }

        return view('potentialcustomer::pages.leads.potential_account.mapping_data', compact('potentialAccounts', 'fails_rows_array_with_errors', 'changed_potentialAccounts', 'duplicated_potentialAccounts'));
    }




    public function insertNewData()
    {

        $new_collected_data = LeadAccountImport::where('created_by', auth()->id())->where('created_as', 'potential')->where('is_new', 1)->get();
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
                'created_as' => 'potential',
                'condition' => 'potential',
                'created_by' => auth()->id(),
            ]);
        }

        Alert::success(__('Success'), __('Lead Account Data inserted Successfully'));
        return redirect()->route('potential_account.index');
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $potentialAccounts = LeadAccount::where('condition', 'potential')->where('created_by', auth()->id())->get();
        } else {
            $potentialAccounts = LeadAccount::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'potential_accounts',$potentialAccounts,$columns);
    }



    public function exportNewData()
    {
        $fileName = 'new_data_before_insert_potential_accounts'. '_' . date('Y-m-d').'.xlsx' ;
        $leadAccounts = LeadAccountImport::where('condition', 'potential')->where('created_by', auth()->id())->get();
        return Excel::download(new NewDataPotentialAccountExport($leadAccounts), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }


    public function exportInvalidRows()
    {
        $fileName = 'invalid-collected-data-rows-' . today() . '.xlsx';
        $invalidDate = ImportDataInvalidRow::where('created_by', auth()->id())
            ->where('model', 'potential_account')
            ->get();
        $export = new InvalidRowExport($invalidDate);
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
