<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::where('module_id','>', 0)->get();
        foreach ($modules as $module) {
            Permit::create([
                'status' => 1,
                'level' => 1,
                'url_module'=> $module->url_module,
                'module_id' => $module->module_id,
                'sub_module_id' =>$module->id,
                'user_id' => 1,
            ]);
        }

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'profile',
            'module_id' => 9,
            'sub_module_id' => 10,
            'user_id' => 2,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'listPost',
            'module_id' => 15,
            'sub_module_id' => 16,
            'user_id' => 2,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'editPost',
            'module_id' => 15,
            'sub_module_id' => 17,
            'user_id' => 2,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'addPost',
            'module_id' => 15,
            'sub_module_id' => 18,
            'user_id' => 2,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'widgetuser',
            'module_id' => 15,
            'sub_module_id' => 19,
            'user_id' => 2,
        ]);


        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'profile',
            'module_id' => '9',
            'sub_module_id' => 10,
            'user_id' => 3,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'listPost',
            'module_id' => 15,
            'sub_module_id' => 16,
            'user_id' => 3,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'editPost',
            'module_id' => 15,
            'sub_module_id' => 17,
            'user_id' => 3,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'addPost',
            'module_id' => 15,
            'sub_module_id' => 18,
            'user_id' => 3,
        ]);

        Permit::create([
            'status' => 1,
            'level' => 1,
            'url_module'=> 'widgetuser',
            'module_id' => 15,
            'sub_module_id' => 19,
            'user_id' => 3,
        ]);
    }
}
