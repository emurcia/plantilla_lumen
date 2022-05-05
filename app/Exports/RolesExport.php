<?php

namespace App\Exports;

use App\Models\Roles;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RolesExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        return Roles::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'rol_nombre'
        ];
    }
}