<?php

namespace Modules\PotentialCustomer\app\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\PotentialCustomer\app\Models\HeadFamilyMember;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeadMemberSelected implements FromQuery, WithHeadings, WithStyles, WithMapping
{
    protected $headMemberIds = [];

    public function __construct($headMemberIds)
    {
        $this->headMemberIds = $headMemberIds;
    }

    public function query()
    {
        return HeadFamilyMember::whereIn('id', $this->headMemberIds);
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Relationship',
            'Link',
            'Date of Birth',
            'National ID',
            'Phone',
            'Personal Image',
            'Front face Id Card',
            'Back face Id Card',
        ];
    }

    public function map($headMember): array
    {
        $headMemberRow = $this->getHeadMemberRow($headMember);
        $familyMemberRows = [];

        foreach ($headMember->familyMembers as $familyMember) {
            $familyMemberRows[] = $this->getFamilyMemberRow($familyMember, $headMember->link->subject);
        }
        return array_merge([$headMemberRow], $familyMemberRows);
    }

    protected function getHeadMemberRow($headMember)
    {
        return [
            $headMember->id,
            $headMember->head_name,
            'Head Member',
            $headMember->link->subject,
            $headMember->head_birth_date,
            $headMember->head_national_id,
            $headMember->head_phone,
            asset('storage/' . $headMember->headFiles->whereNull('family_member_id')->first()->personal_image),
            asset('storage/' . $headMember->headFiles->whereNull('family_member_id')->first()->front_national_id_card),
            asset('storage/' . $headMember->headFiles->whereNull('family_member_id')->first()->back_national_id_card),
        ];
    }

    protected function getFamilyMemberRow($familyMember, $linkSubject)
    {
        return [
            $familyMember->id,
            $familyMember->name,
            $familyMember->relationship,
            $linkSubject,
            $familyMember->birth_date,
            $familyMember->national_id,
            $familyMember->phone,
            asset('storage/' . $familyMember->familyMemberFiles->first()->personal_image),
            asset('storage/' . $familyMember->familyMemberFiles->first()->front_national_id_card),
            asset('storage/' . $familyMember->familyMemberFiles->first()->back_national_id_card),
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("C$row")->getValue();
            if ($cellValue === 'Head Member') {
                $styleArray = [
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0000'],
                    ],
                ];
                $sheet->getStyle("A$row:J$row")->applyFromArray($styleArray);
            }
        }
        $styleArray = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'],
            ],
        ];
        $sheet->getStyle("A1:J1")->applyFromArray($styleArray);
        return [];
    }

}
