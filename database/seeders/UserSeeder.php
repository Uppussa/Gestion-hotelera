<?php

namespace Database\Seeders;

use App\Imports\UserImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new UserImport, base_path().'/database/seeders/Users.xlsx');
    }
}
