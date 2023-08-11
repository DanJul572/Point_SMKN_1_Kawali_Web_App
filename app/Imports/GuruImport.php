<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GuruImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key > 0) {
                Guru::create([
                    'nama' => $row[0],
                    'nip' => $row[1],
                    'kode' => 'kodesaya',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
