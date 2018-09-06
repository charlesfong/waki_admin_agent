<?php

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            'code' => 'B40',
            'name' => 'GAJAH MADA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B42',
            'name' => 'KALIBATA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B45',
            'name' => 'PERMATA HIJAU',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B49',
            'name' => 'MEDAN',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B73',
            'name' => 'MANGGA DUA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B80',
            'name' => 'SALES AND SERVICE',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B81',
            'name' => 'SEASON CITY',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'B93',
            'name' => 'BANDUNG',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F01',
            'name' => 'TIM BUDI',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F02',
            'name' => 'TIM BASORI',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F12',
            'name' => 'TIM WINNA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F32',
            'name' => 'TIM ADI',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F35',
            'name' => 'TIM SELVI',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F36',
            'name' => 'TIM MALA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F37',
            'name' => 'TIM PUTU',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F40',
            'name' => 'TIM JOHN',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F42',
            'name' => 'TIM OTTO',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F52',
            'name' => 'GIANT',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F68',
            'name' => 'DELIVERY',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F80',
            'name' => 'TUNJUNGAN PLAZA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F81',
            'name' => 'SURABAYA PLAZA',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F84',
            'name' => 'PTC',
            'country' => 'INDONESIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F89',
            'name' => 'DARMO PARK',
            'country' => 'INDONESIA',
        ]);
    }
}
