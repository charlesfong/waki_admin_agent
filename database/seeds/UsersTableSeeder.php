<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
        	'code' => 'EMP-0001',
        	'name' => 'ADMIN',
        	'username' => 'ADMIN',
        	'password' => Hash::make('metro299admin'),
        	'branch_id' => '23', //darmo park
        	'permissions' => json_encode([
                //MPC
        		'add-mpc' => true,
                'browse-mpc' => true,
                'find-mpc' => true,
        		'edit-mpc' => true,
                'delete-mpc' => true,
                'all-branch-mpc' => true,
                'all-country-mpc' => true,
                //DATA_UNDANGAN
        		'add-data-undangan' => true,
                'browse-data-undangan' => true,
                'find-data-undangan' => true,
        		'edit-data-undangan' => true,
                'delete-data-undangan' => true,
                'all-branch-data-undangan' => true,
                'all-country-data-undangan' => true,
                //DATA_OUTSITE
        		'add-data-outsite' => true,
                'browse-data-outsite' => true,
                'find-data-outsite' => true,
        		'edit-data-outsite' => true,
                'delete-data-outsite' => true,
                'all-branch-data-outsite' => true,
                'all-country-data-outsite' => true,
                //DATA_THERAPY
        		'add-data-therapy' => true,
                'browse-data-therapy' => true,
                'find-data-therapy' => true,
        		'edit-data-therapy' => true,
                'delete-data-therapy' => true,
                'all-branch-data-therapy' => true,
                'all-country-data-therapy' => true,
                //TYPE_CUST
                'add-type-cust' => true,
                'browse-type-cust' => true,
        		'edit-type-cust' => true,
                'delete-type-cust' => true,
                //CSO
        		'add-cso' => true,
                'browse-cso' => true,
        		'edit-cso' => true,
                'delete-cso' => true,
                'all-branch-cso' => true,
                'all-country-cso' => true,
                //BRANCH
                'add-branch' => true,
                'browse-branch' => true,
                'edit-branch' => true,
                'delete-branch' => true,
                'all-country-branch' => true,
                //USER
                'add-user' => true,
                'browse-user' => true,
                'edit-user' => true,
                'delete-user' => true,
                'all-branch-user' => true,
                'all-country-user' => true,
        	]),
        ]);
        $admin->roles()->attach(1);
    }
}
