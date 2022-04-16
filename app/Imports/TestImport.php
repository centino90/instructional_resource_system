<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResourceImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        dd($rows);
        foreach ($rows as $row)
        {
           dd($row);
        }
    }
}
