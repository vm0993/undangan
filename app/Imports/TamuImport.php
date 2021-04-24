<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TamuImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Guest([
            'name' => $row['name'],
            'alamat1' => $row['alamat1'],
            'alamat2' => $row['alamat2'],
            'alamat3' => $row['alamat3'],
            'no_telp' => $row['no_telp'],
            'email' => $row['email'],
            'keterangan' => $row['keterangan'],
            'user_id' => auth()->user()->id,
        ]);
    }
}
