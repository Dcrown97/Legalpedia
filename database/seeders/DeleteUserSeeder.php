<?php

namespace Database\Seeders;

use App\Models\UserTest;
use Illuminate\Database\Seeder;

class DeleteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = UserTest::where('role_id', NULL )->delete();
        $users = UserTest::where('role_id', 2 )->delete();
        

    }
}
