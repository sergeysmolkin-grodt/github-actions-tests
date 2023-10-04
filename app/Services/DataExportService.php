<?php
namespace App\Services;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExportService implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    public function collection()
    {
        return User::role('student')->with('userDetails')->get();
    }

    public function map($user): array
    {
        return [
            $user->firstname,
            $user->lastname,
            $user->email,
            $user->userDetails ? $user->userDetails->mobile : '',
            $user->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Date'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
