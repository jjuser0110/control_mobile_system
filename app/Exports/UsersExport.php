<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return User::where('role_id', 3)
                   ->where('is_active', 1)
                   ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Username',
            'Email',
            'Created At',
            'NRIC',
            'Contact No',
            'User Status',
            'Company Name',
            'Company Contact',
            'Job Title',
            'Salary',
            'Salary Date',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name ?? '',
            $user->username ?? '',
            $user->email ?? '',
            $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
            " " . ($user->nric ?? ''),
            " " . ($user->contact_no ?? ''),
            $user->user_status ?? '',
            $user->company_name ?? '',
            " " . ($user->company_contact ?? ''),
            $user->job_title ?? '',
            $user->salary ?? '',
            $user->salary_date ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT, // NRIC
            'F' => NumberFormat::FORMAT_TEXT, // Contact No
            'I' => NumberFormat::FORMAT_TEXT, // Company Contact
        ];
    }
}