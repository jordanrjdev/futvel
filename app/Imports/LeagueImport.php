<?php

namespace App\Imports;

use App\Models\League;
use Maatwebsite\Excel\Concerns\ToModel;

class LeagueImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!empty($row[0])) {
            return new League([
                'name' => $row[0],
            ]);
        }
    }
}
