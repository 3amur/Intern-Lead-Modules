<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Models\FamilyMember;
use Modules\PotentialCustomer\app\Models\RelationshipType;
use Modules\PotentialCustomer\app\DataTables\FamilyMembersDataTable;
use Modules\PotentialCustomer\app\Http\Requests\FamilyMemberRequest;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FamilyMembersDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.leads.family_members.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $potentialAccounts = LeadAccount::where('condition','potential')
        ->where('created_by',auth()->id())
        ->where('status','active')
        ->select('id','account_name')->get();
        $relationships = RelationshipType::all();
        return view('potentialcustomer::pages.leads.family_members.create_edit',compact('potentialAccounts','relationships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyMemberRequest $request)
    {
        $personalImage = $nationalIdCard = NULL;
        if($request->has('personal_image') && $request->has('national_id_card'))
        {
            $personalImage = Storage::put('collected-date/form/personal-images',$request->personal_image);
            $nationalIdCard = Storage::put('collected-date/form/id-cards',$request->national_id_card);
        }

        FamilyMember::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'national_id' => $request->national_id,
            'birth_date' => $request->birth_date,
            'personal_image'=>$personalImage,
            'national_id_card'=>$nationalIdCard,
            'relationship_type_id'=>$request->relationship_type_id,
            'potential_account_id'=>$request->potential_account_id,
            'status'=>$request->status,
            'created_by'=>$request->created_by,
        ]);

        Alert::success(__('Success'),__('Family Member Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyMember $familyMember)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyMember $familyMember)
    {
        $potentialAccounts = LeadAccount::where('condition','potential')
        ->where('created_by',auth()->id())
        ->where('status','active')
        ->select('id','account_name')->get();
        $relationships = RelationshipType::all();
        return view('potentialcustomer::pages.leads.family_members.create_edit',compact('familyMember','potentialAccounts','relationships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyMemberRequest $request, FamilyMember $familyMember)
    {
        $personalImage = $nationalIdCard = NULL;

        if($request->has('personal_image'))
        {
            Storage::delete($familyMember->personal_image);
            $personalImage = Storage::put('collected-date/form/personal-images',$request->personal_image);
        }

        if($request->has('national_id_card'))
        {
            Storage::delete($familyMember->national_id_card);
            $nationalIdCard = Storage::put('collected-date/form/id-cards',$request->national_id_card);
        }

        $familyMember->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'national_id' => $request->national_id,
            'birth_date' => $request->birth_date,
            'personal_image'=>$personalImage,
            'national_id_card'=>$nationalIdCard,
            'relationship_type_id'=>$request->relationship_type_id,
            'potential_account_id'=>$request->potential_account_id,
            'status'=>$request->status,
            'updated_by'=>$request->created_by,
        ]);
        Alert::success(__('Success'),__('Family Member updated Successfully'));
        return redirect()->route('family_members.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyMember $familyMember)
    {
        Storage::delete($familyMember->personal_image);
        Storage::delete($familyMember->national_id_card);
        $familyMember->update([
            'deleted_by'=>auth()->id()
        ]);
        $familyMember->delete();
        Alert::success(__('Success'),__('Family Member  deleted Successfully'));
    }
}
