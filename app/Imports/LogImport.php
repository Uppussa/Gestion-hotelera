<?php

namespace App\Imports;

use App\Models\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Spreadsheet\Shared\Date;
use Carbon\Carbon;

class LogImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return Log::create([
            'id' => $row['id'],
            'fc_log' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fc_log']),
            'action_log' => $row['action_log'],
            'tipo_log' => $row['tipo_log'],
            'user_id' => $row['user_id'],
        ]);
    }
}
