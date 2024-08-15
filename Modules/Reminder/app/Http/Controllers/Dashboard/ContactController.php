<?php

namespace Modules\Reminder\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Modules\Reminder\app\Models\Phone;
use Nwidart\Modules\Routing\Controller;
use Modules\Reminder\app\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;
use Modules\Reminder\app\DataTables\ContactsDataTable;
use Modules\Reminder\app\Http\Requests\ContactRequest;

class ContactController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(ContactsDataTable $dataTable)
    {

        return $dataTable->render('reminder::pages.contacts.index');
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
    public function store(ContactRequest $request)
    {
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

                foreach ($request->phone as $phone) {
            Phone::create([
                'phone' => $phone,
                'contact_id' => $contact->id,
                'created_by' => auth()->id(),
            ]);
        }


        Alert::success(__('Success'), __('Contact Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('reminder::pages.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        foreach ($contact->phones as $phone) {
            $phone->update(['deleted_by' => auth()->id()]);
            $phone->delete();
        }

        foreach ($request->phone as $phone) {
            Phone::create([
                'phone' => $phone,
                'contact_id' => $contact->id,
                'created_by' => auth()->id(),
            ]);
        }
        Alert::success(__('Success'), __('Contact Updated Successfully'));
        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->update([
            'deleted_by' => auth()->id()
        ]);
        foreach ($contact->phones as $phone) {
            $phone->delete();
        }
        $contact->delete();
        Alert::success(__('Success'), __('Contact Removed Successfully'));
    }


    public function parseVcfToArray($filePath)
    {
        $vcfData = file_get_contents($filePath);

        // Split the VCF data into individual vCards
        $vCards = preg_split('/(?<=\n)(BEGIN:VCARD)/', $vcfData, -1, PREG_SPLIT_NO_EMPTY);

        $contacts = [];

        foreach ($vCards as $vCard) {
            $contact = [];
            preg_match('/FN:(.*?)\n/', $vCard, $matches);
            $contact['name'] = isset($matches[1]) ? trim($matches[1]) : null;

           /*  preg_match_all('/EMAIL;TYPE=(.*?):(.*?)\n/', $vCard, $email_matches, PREG_SET_ORDER);

            foreach ($email_matches as $email_match) {
                $type = isset($email_match[1]) ? trim($email_match[1]) : 'UNKNOWN';
                $email = isset($email_match[2]) ? trim($email_match[2]) : null;
                $contact['email'][$type] = $email;
            } */

            preg_match_all('/TEL;(.*?):(.*?)\n/', $vCard, $phone_matches, PREG_SET_ORDER);

            foreach ($phone_matches as $phone_match) {
                $type = isset($phone_match[1]) ? trim($phone_match[1]) : 'UNKNOWN';
                $number = isset($phone_match[2]) ? trim($phone_match[2]) : null;

                $contact['phone'][$type] = $number;
            }

            $contacts[] = $contact;
        }
        return $contacts;
    }


    public function importVCard(ContactRequest $request)
    {
        try {
            $vCards = $this->parseVcfToArray($request->file);
            foreach ($vCards as $vCard) {
                $contact = Contact::create([
                    'name' => $vCard['name'],
                    'status'=>'active',
                    'created_by' => auth()->id(),
                ]);

                // Check if 'phone' key exists before iterating
                if (isset($vCard['phone']) && is_array($vCard['phone'])) {
                    foreach ($vCard['phone'] as $type => $number) {
                        Phone::create([
                            'phone' => str_replace(['-', '+2'], '', $number),
                            'contact_id' => $contact->id,
                            'created_by' => auth()->id(),
                        ]);
                    }
                }
            }

            return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('contacts.index')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('An error occurred while importing your contacts. check that all names and numbers are exist '), 'redirect_url' => route('contacts.index')]);
        }
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $contacts = Contact::where('created_by', auth()->id())->get();
        } else {
            $contacts = Contact::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'contacts',$contacts,$columns);

    }


}
