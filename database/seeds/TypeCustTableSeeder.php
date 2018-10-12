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
            'name' => 'FACEBOOK',
            'type_input' => 'OUT-SITE',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MS RUMAH',
            'type_input' => 'OUT-SITE',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'DEMO',
            'type_input' => 'OUT-SITE',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'CFD',
            'type_input' => 'OUT-SITE',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MGM',
            'type_input' => 'OUT-SITE',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'FACEBOOK',
            'type_input' => 'THERAPY',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MS RUMAH',
            'type_input' => 'THERAPY',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'DEMO',
            'type_input' => 'THERAPY',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'CFD',
            'type_input' => 'THERAPY',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MGM',
            'type_input' => 'THERAPY',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'FACEBOOK',
            'type_input' => 'UNDANGAN',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'UNDANGAN HUT',
            'type_input' => 'UNDANGAN',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'UNDANGAN BANK',
            'type_input' => 'UNDANGAN',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'TELKOMSEL',
            'type_input' => 'UNDANGAN',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'MGM',
            'type_input' => 'UNDANGAN',
        ]);

        DB::table('type_custs')->insert([
            'name' => 'WHATSAPP',
            'type_input' => 'UNDANGAN',
        ]);
    }
}
