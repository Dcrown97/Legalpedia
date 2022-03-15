<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserTest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current_users = DB::table('users_old')->get();
        $users = (json_decode(file_get_contents(database_path('migrations/files/leads.json'))));
        $this->command->getOutput()->progressStart(count($users)); //start progress bar

        foreach($users as $user) {
            $user = (array) $user;
            $isExistingUser = UserTest::where('email', $user['Email'])->first();

            if($isExistingUser){ //is found
                $isExistingUser->name = $user['Name'];
                $isExistingUser->surname = $user['Surname'];
                $isExistingUser->email = $user['Email'];
                $isExistingUser->phone = $user['PhoneNumber'];
                $isExistingUser->password = bcrypt($user['Email'] . $user['PhoneNumber']);
                $isExistingUser->package_id = 20;
                $isExistingUser->active_date = now();
                $isExistingUser->expiry_date = now()->addDays(30);
                $isExistingUser->status = 'active';
                $isExistingUser->save();
            }else{ //not found
                UserTest::create([
                    'name' => $user['Name'],
                    'surname' => $user['Surname'],
                    'email' => $user['Email'],
                    'role_id' => 2,
                    'phone' => $user['PhoneNumber'],
                    'password' => bcrypt($user['Email'] . $user['PhoneNumber']),
                    'package_id' => 20,
                    'active_date' => now(),
                    'expiry_date' => now()->addDays(30),
                    'status' => 'active',
                ]);
            }

            $this->command->getOutput()->progressAdvance();

        }

        $this->command->getOutput()->progressFinish();

    }
}
