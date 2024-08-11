<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cat;
use App\Models\Module;
use App\Models\Permit;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CatSeeder::class,
            ModuleSeeder::class,
            //Seeders
            UserSeeder::class,
            PermitSeeder::class,
            LogSeeder::class,
        ]);
    }
}
