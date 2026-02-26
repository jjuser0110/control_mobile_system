<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserContactsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        $user = User::with('contact_number')->findOrFail($this->userId);
        return $user->contact_number;
    }

    public function headings(): array
    {
        return [
            'Contact Name',
            'Contact Number',
        ];
    }

    public function map($contact): array
    {
        return [
            $contact->displayName ?? '',
            " " . ($contact->filtered_phone_numbers ?? ''),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Contact Number
        ];
    }
}