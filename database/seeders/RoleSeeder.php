<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $roles = [
            ['name'=>'Admin'],
            ['name'=>'Customer'],
            ['name'=>'Staff'],
            ['name'=>'Developer'],
        ];
        foreach($roles as $role) {
            Role::create(['name'=>$role['name']]);
        }
    }
}
