<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            array(
                [
                    'id'         => 1,
                    'name'       => 'Admin',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 2,
                    'name'       => 'Employeer',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 3,
                    'name'       => 'Freelancer',
                    'guard_name' =>   'api',
                ],

            )
        );
    }
}
