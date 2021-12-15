<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $dictionaries = DB::table('dictionary')->get();
        // $firstId = 1;
        // foreach($dictionaries as $dictionary) {
        //     $uuid = $dictionary->uuid;
        //     DB::table('dictionary')->where('uuid', $uuid)->update(['id' => $firstId++]);
        // }
    }
}
