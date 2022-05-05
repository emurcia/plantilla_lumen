<?php

namespace App\Imports;

use App\Models\Roles;


# importamos las clases
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class RolesImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
{

    public function model(array $row)
    {
        return new Roles(
            [
                'rol_nombre' => $row[0]
            ]
        );
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    public function startRow(): int
    {
        return 2;
    }
}