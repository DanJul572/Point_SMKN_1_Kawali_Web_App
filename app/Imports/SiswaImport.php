<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key > 0) {
                Siswa::create([
                    'nama' => $row[0],
                    'nis' => $row[1],
                    'kode' => 'kodesaya',
                    'tingkat_id' => $row[2],
                    'kelas_id' => $row[3],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
