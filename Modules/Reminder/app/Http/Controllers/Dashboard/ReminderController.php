<?php

namespace Modules\Reminder\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Reminder\app\Models\Phone;
use Nwidart\Modules\Routing\Controller;
use Modules\Reminder\app\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\Reminder\app\Models\Reminder;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\Reminder\app\DataTables\RemindersDataTable;
use Modules\Reminder\app\Http\Requests\ReminderRequest;

class ReminderController extends Controller
{

    public function home()
    {
        return view("reminder::pages.home");
    }


    /**
     * Display a listing of the resource.
     */
    public function index(RemindersDataTable $dataTable)
    {
        $leadAccounts = LeadAccount::where('created_by', auth()->id())->where('status', 'active')->get();
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        return $dataTable->render('reminder::pages.reminders.index', compact('leadAccounts', 'contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ReminderRequest $request)
    {
        try {
            DB::beginTransaction();
            $reminder = Reminder::create([
                'reminder_title' => $request->reminder_title,
                'reminder_start_date' => $request->reminder_start_date,
                'reminder_end_date' => $request->reminder_end_date,
                'description' => $request->description,
                'reminder_relation' => $request->reminder_relation,
                'reminder_type' => $request->reminder_type,
                'lead_id' => $request->lead_id,
                'status' => $request->status,
                'created_by' => auth()->id(),
            ]);

            if ($request->reminder_type == 'call') {
                $oldContact = [];
                foreach ($request->contact_id as $oldContacts) {
                    $oldContact[] = $oldContacts;
                }
                $reminder->contacts()->attach($oldContact);

                $contactData = $request->only(['name', 'phone', 'email']);
                if ($contactData) {
                    $contacts = [];

                    foreach ($contactData['name'] as $key => $value) {
                        $contact = Contact::create([
                            'name' => isset ($contactData['name'][$key]) ? $contactData['name'][$key] : null,
                            'email' => isset ($contactData['email'][$key]) ? $contactData['email'][$key] : null,
                            'created_by' => auth()->user()->id,
                        ]);

                        Phone::create([
                            'phone' => isset ($contactData['phone'][$key]) ? $contactData['phone'][$key] : null,
                            'contact_id' => $contact->id,
                            'created_by' => auth()->id(),
                        ]);

                        $contacts[] = $contact->id;
                    }
                    $reminder->contacts()->attach($contacts);
                }

            }
            DB::commit();
            Alert::success(__('Success'), __('Reminder Created Successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Reminder creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        return view('reminder::pages.reminders.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        $leadAccounts = LeadAccount::where('created_by', auth()->id())->where('status', 'active')->get();
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminderContacts = $reminder->contacts;
        return view('reminder::pages.reminders.edit', compact('reminder', 'leadAccounts', 'contacts', 'reminderContacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReminderRequest $request, Reminder $reminder)
    {
        $this->updateReminder($request, $reminder);
        Alert::success(__('Success'), __('Reminder Updated Successfully'));
        return redirect()->route('reminders.index');
    }

    public static function updateReminder($request, $reminder)
    {
        $reminder->update([
            'reminder_type' => $request->reminder_type,
            "reminder_relation" => $request->reminder_relation,
            "lead_id" => $request->reminder_relation != null ? $request->lead_id : null,
            "reminder_title" => $request->reminder_title,
            'reminder_start_date' => $request->reminder_start_date,
            'reminder_end_date' => $request->reminder_end_date,
            "description" => $request->description,
            "status" => $request->status,
            'updated_by' => auth()->id(),
        ]);
        if ($request->reminder_type == 'call') {
            $reminder->contacts()->detach();
            $reminder->contacts()->attach($request->contact_id);
            $contactData = $request->only(['name', 'phone', 'email']);
            if ($contactData) {
                $contacts = [];

                foreach ($contactData['name'] as $key => $value) {
                    $contact = Contact::create([
                        'name' => isset ($contactData['name'][$key]) ? $contactData['name'][$key] : null,
                        'email' => isset ($contactData['email'][$key]) ? $contactData['email'][$key] : null,
                        'created_by' => auth()->user()->id,
                    ]);

                    Phone::create([
                        'phone' => isset ($contactData['phone'][$key]) ? $contactData['phone'][$key] : null,
                        'contact_id' => $contact->id,
                        'created_by' => auth()->id(),
                    ]);

                    $contacts[] = $contact->id;
                }
                $reminder->contacts()->attach($contacts);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->update([
            'deleted_by' => auth()->id()
        ]);
        if ($reminder->reminder_type == 'call') {
            $reminder->contacts()->detach();
        }
        $reminder->delete();
        Alert::success(__('Success'), __('Reminder Removed Successfully'));
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $reminders = Reminder::where('created_by', auth()->id())->get();
        } else {
            $reminders = Reminder::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'reminders',$reminders,$columns);

    }

}
