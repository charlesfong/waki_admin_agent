<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'name' => 'BCA',
        ]);
        DB::table('banks')->insert([
            'name' => 'BRI',
        ]);
        DB::table('banks')->insert([
            'name' => 'BNI',
        ]);
        DB::table('banks')->insert([
            'name' => 'CIMB NIAGA',
        ]);
        DB::table('banks')->insert([
            'name' => 'OCBC',
        ]);
        DB::table('banks')->insert([
            'name' => 'MEGA',
        ]);
        DB::table('banks')->insert([
            'name' => 'HSBC',
        ]);
    }
}
