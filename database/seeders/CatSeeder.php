<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cat::create([
            'status' => 1,
            'nom' => 'Basic',
            'desc' => 'Basic',
            'level' => 1,
            'icon' => 'fas fa-user',
            'color' => 'success',
            'slug' => 'basic',
            'filter_on' => 'users',
        ]);

        Cat::create([
            'status' => 1,
            'nom' => 'Admin',
            'desc' => 'Admin',
            'level' => 2,
            'icon' => 'fas fa-user-cog',
            'color' => 'danger',
            'slug' => 'admin',
            'filter_on' => 'users',
        ]);

        Cat::create([
            'status' => 3,
            'nom' => 'Root',
            'desc' => 'Root',
            'level' => 1,
            'icon' => 'fas fa-user-shield',
            'color' => 'dark',
            'slug' => 'root',
            'filter_on' => 'users',
        ]);
    }
}
