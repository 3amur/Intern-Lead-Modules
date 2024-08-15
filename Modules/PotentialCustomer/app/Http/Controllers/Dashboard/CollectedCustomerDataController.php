<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Routing\Controller;
use Modules\PotentialCustomer\app\Models\Link;
use Modules\PotentialCustomer\app\Models\MemberFile;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Models\FamilyMember;
use Modules\PotentialCustomer\app\Models\HeadFamilyMember;
use Modules\PotentialCustomer\app\Exports\HeadMemberSelected;
use Modules\PotentialCustomer\app\Exports\CollectedCustomerDataExport;
use Modules\PotentialCustomer\app\Http\Requests\CollectedFormDataStoreRequest;
use Modules\PotentialCustomer\app\DataTables\ImportedCustomerDataDataTable;

class CollectedCustomerDataController extends Controller
{

    public function formPage(Request $request)
    {
        // Retrieve parameters from query string
        $customerName = $request->query('customer_name');
        $customerId = $request->query('customer_id');
        $hasFamily = $request->query('has_family');
        $wifeHusband = $request->query('wife_husband');
        $hasParent = $request->query('has_parent');
        $hasChildren = $request->query('has_children');
        $childrenCount = $request->query('children_count');
        $linkId = $request->query('link');

        $link = Link::where('id', $linkId)->first();
        if ($link && $link->status == 'inactive') {

            abort(419);
        } elseif ($link && $link->status == 'active') {
            $customerName = str_replace('_', ' ', ucwords($customerName));
            return view('potentialcustomer::pages.leads.collected_data.form_page', compact(
                'linkId',
                'customerName',
                'customerId',
                'hasFamily',
                'wifeHusband',
                'hasParent',
                'hasChildren',
                'childrenCount'
            ));
        } else {
            abort(404);
        }
    }

    public function storeFamilyData(CollectedFormDataStoreRequest $request)
    {
        dd($request);
        try {
            DB::beginTransaction();

            $headFamilyMember = $this->createHeadFamilyMember($request);

            $this->uploadHeadPersonalImageAndIdCards($request, $headFamilyMember);

            $combinedNationalIdCards = $this->combineNationalIdCards($request);

            $this->storeFamilyMembers($request, $headFamilyMember, $combinedNationalIdCards);

            DB::commit();

            return redirect()->route('collected_customer_data.successPage');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e);
        }
    }

    protected function createHeadFamilyMember(CollectedFormDataStoreRequest $request)
    {
        return HeadFamilyMember::create([
            'head_name' => $request->head_name,
            'head_phone' => $request->head_phone,
            'head_national_id' => $request->head_national_id ? $request->head_national_id : $request->head_passport_id ,
            'head_birth_date' => $request->head_birth_date,
            'potential_account_id' => $request->potential_account_id,
            'link_id' => $request->link_id,
        ]);
    }

    protected function uploadHeadPersonalImageAndIdCards(CollectedFormDataStoreRequest $request, HeadFamilyMember $headFamilyMember)
    {
        if ($request->hasFile('head_personal_image') && $request->hasFile('head_national_id_card')) {
            $headPersonalImage = Storage::putFile('collected-data/form/personal-images', $request->file('head_personal_image'));
            MemberFile::create([
                'personal_image' => $headPersonalImage,
                'head_member_id' => $headFamilyMember->id,
            ]);

            foreach ($request->head_national_id_card as $headNationalCard) {
                $headNationalIdCard = Storage::putFile('collected-data/form/id-cards', $headNationalCard);
                MemberFile::create([
                    'national_id_card' => $headNationalIdCard,
                    'head_member_id' => $headFamilyMember->id,
                ]);
            }
        }
    }

    protected function combineNationalIdCards(CollectedFormDataStoreRequest $request)
    {
        $combinedNationalIdCards = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'national_id_card_') === 0 && is_array($value)) {
                $combinedNationalIdCards[$key] = $value;
            }
        }
        return $combinedNationalIdCards;
    }

    protected function storeFamilyMembers(CollectedFormDataStoreRequest $request, HeadFamilyMember $headFamilyMember, array $combinedNationalIdCards)
    {
        $familyMembers = $request->only([
            'name',
            'phone',
            'national_id',
            'passport_id',
            'birth_date',
            'personal_image',
            'national_id_card',
        ]);

        if ($familyMembers) {
            foreach ($familyMembers['name'] as $index => $memberName) {
                $nationalId = isset($familyMembers['national_id'][$index]) ? $familyMembers['national_id'][$index] : null;
                $passportId = isset($familyMembers['passport_id'][$index]) ? $familyMembers['passport_id'][$index] : null;

                // Use either national_id or passport_id based on availability
                $id = $nationalId ?? $passportId;
                $familyMember = FamilyMember::create([
                    'name' => $familyMembers['name'][$index],
                    'phone' => $familyMembers['phone'][$index],
                    'national_id' => $id ,
                    'birth_date' => $familyMembers['birth_date'][$index],
                    'relationship' => $request->relationship[$index],
                    'potential_account_id' => $request->potential_account_id,
                    'head_member_id' => $headFamilyMember->id,
                    'status' => 'active',
                ]);

                $this->uploadFamilyMemberImagesAndIdCards($request, $familyMembers, $combinedNationalIdCards, $index, $familyMember, $headFamilyMember);
            }
        }
    }

    protected function uploadFamilyMemberImagesAndIdCards(CollectedFormDataStoreRequest $request, array $familyMembers, array $combinedNationalIdCards, $index, FamilyMember $familyMember, HeadFamilyMember $headFamilyMember)
    {
        if ($request->hasFile('personal_image') && $combinedNationalIdCards) {
            $personalImage = Storage::putFile('collected-data/form/personal-images', $familyMembers['personal_image'][$index]);
            MemberFile::create([
                'personal_image' => $personalImage,
                'family_member_id' => $familyMember->id,
                'head_member_id' => $headFamilyMember->id,
            ]);

            if (isset($combinedNationalIdCards["national_id_card_$index"])) {
                foreach ($combinedNationalIdCards["national_id_card_$index"] as $card) {
                    $nationalIdCard = Storage::putFile('collected-data/form/id-cards', $card);

                    MemberFile::create([
                        'national_id_card' => $nationalIdCard,
                        'family_member_id' => $familyMember->id,
                        'head_member_id' => $headFamilyMember->id,
                    ]);
                }
            }
        }
    }


    public function showCollectedDataDetails(ImportedCustomerDataDataTable $dataTable, $potentialAccountId)
    {

        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);

        $headMembers = $potentialAccount->headMembers;
        $importedCustomerData = $potentialAccount->importedData;
        return $dataTable->render('potentialcustomer::pages.leads.collected_data.collected_data_details', compact('potentialAccount', 'headMembers', 'importedCustomerData'));
    }

    public function showHeadMemberDetails($headMemberId)
    {
        $headMember = HeadFamilyMember::findOrFail($headMemberId);
        $familyMembers = $headMember->familyMembers;
        return view('potentialcustomer::pages.leads.collected_data.headMembers_details',compact('familyMembers','headMember'));
    }

    public function SuccessPage()
    {
        return view('potentialcustomer::pages.leads.collected_data.success_page');
    }

    public function chartPage()
    {
        return view('potentialcustomer::pages.leads.collected_data.charts');
    }

    public function exportCollectedData($potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);

        $fileName = Str::slug($potentialAccount->account_name) . '-collected-data-from-form-page.xlsx';

        return Excel::download(new CollectedCustomerDataExport($potentialAccount), $fileName);
    }


    public function exportSelectedMembers(Request $request,$potentialAccountId)
    {
        if($request->selectedCheckboxes == null){
            return response()->json([
                'success'=>false
                ],400);
        }
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        $fileName = Str::slug($potentialAccount->account_name) . '-Selected Head Members.xlsx';
        return Excel::download(new HeadMemberSelected($request->selectedCheckboxes), $fileName, \Maatwebsite\Excel\Excel::XLSX);

    }

}
