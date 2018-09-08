<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeCustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_custs')->insert([
            'name' => 'Facebook',
            'type_input' => 'Out-Site',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Ms Rumah',
            'type_input' => 'Out-Site',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Demo',
            'type_input' => 'Out-Site',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'CFD',
            'type_input' => 'Out-Site',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MGM',
            'type_input' => 'Out-Site',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Facebook',
            'type_input' => 'Undangan',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Undangan HUT',
            'type_input' => 'Undangan',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Undangan Bank',
            'type_input' => 'Undangan',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Telkomsel',
            'type_input' => 'Undangan',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MGM',
            'type_input' => 'Undangan',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'Whatsapp',
            'type_input' => 'Undangan',
        ]);
    }
}
