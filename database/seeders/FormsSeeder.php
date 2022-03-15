<?php

namespace Database\Seeders;
use App\Models\FormsPrecedence;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $forms = DB::table('forms_precedence')->get();
        // $firstId = 1;
        // foreach($forms as $form) {
        //     $uuid = $form->uuid;
        //     DB::table('forms_precedence')->where('uuid', $uuid)->update(['id' => $firstId++]);
        // }
    }
}
