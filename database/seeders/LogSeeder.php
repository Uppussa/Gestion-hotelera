<?php

namespace Database\Seeders;

use App\Imports\LogImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new LogImport, base_path().'/database/seeders/Logs.xlsx');
    }
}
