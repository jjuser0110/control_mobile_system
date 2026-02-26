<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserCallLogsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        $user = User::with('call_logs')->findOrFail($this->userId);
        return $user->call_logs;
    }

    public function headings(): array
    {
        return [
            'Contact Name',
            'Contact Number',
            'Duration',
            'Type',
            'Time',
        ];
    }

    public function map($call_log): array
    {
        return [
            $call_log->name ?? '',
            " " . ($call_log->phoneNumber ?? ''), // Space prefix for phone number
            $call_log->duration ?? '',
            $call_log->type ?? '',
            $call_log->timestamp ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Contact Number
        ];
    }
}