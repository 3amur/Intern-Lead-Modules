<?php

namespace Modules\Reminder\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Modules\Reminder\app\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\Reminder\app\Models\Reminder;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\Reminder\app\Http\Requests\ReminderRequest;

class CalendarController extends Controller
{
    public function calendar()
    {
        $leadAccounts = LeadAccount::where('created_by', auth()->id())->where('status', 'active')->get();
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        return view('reminder::pages.calendar',compact('leadAccounts','contacts'));
    }

    public function remindersOnCalendar()
    {
        $reminders = Reminder::where('status','active')->where('created_by', auth()->id())->get();
        return response([
            'success'=>true,
            'data'=> $reminders
        ],200);
    }

    public function editRemindersOnCalendar(Reminder $reminder)
    {
        $leadAccounts = LeadAccount::where('created_by', auth()->id())->where('status', 'active')->get();
        $contacts = Contact::where('created_by', auth()->id())->where('status', 'active')->get();
        $reminderContacts = $reminder->contacts;
        return view('reminder::pages.reminders.edit-reminder-calendar', compact('reminder', 'leadAccounts', 'contacts', 'reminderContacts'));
    }

    public function updateRemindersOnCalendar(ReminderRequest $request, Reminder $reminder)
    {
        ReminderController::updateReminder($request, $reminder);
        Alert::success(__('Success'), __('Reminder Updated Successfully'));
        return redirect()->route('reminders.calendar');
    }

    public function updateDateWithDragAndDrop(Request $request)
    {
        $reminder = Reminder::findOrFail($request->reminderId);
        if($reminder)
        {
            $reminder->update([
                'reminder_start_date'=>$request->start_date,
                'reminder_end_date' =>$request->end_date,
                'updated_by'=>auth()->id()
            ]);
        }
    }
}
