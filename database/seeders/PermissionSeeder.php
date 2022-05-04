<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('permissions')->insert(
            array(
                [
                    'id'         => 1,
                    'name'       => 'index.users',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 2,
                    'name'       => 'create.users',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 3,
                    'name'       => 'edit.users',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 4,
                    'name'       => 'update.users',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 5,
                    'name'       => 'delete.users',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 6,
                    'name'       => 'index.jobs',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 7,
                    'name'       => 'create.jobs',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 8,
                    'name'       => 'edit.jobs',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 9,
                    'name'       => 'update.jobs',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 10,
                    'name'       => 'delete.jobs',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 11,
                    'name'       => 'index.proposals',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 12,
                    'name'       => 'create.proposals',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 13,
                    'name'       => 'edit.proposals',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 14,
                    'name'       => 'update.proposals',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 15,
                    'name'       => 'delete.proposals',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 16,
                    'name'       => 'index.resumes',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 17,
                    'name'       => 'create.resumes',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 18,
                    'name'       => 'edit.resumes',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 19,
                    'name'       => 'update.resumes',
                    'guard_name' =>   'api',
                ],
                [
                    'id'         => 20,
                    'name'       => 'delete.resumes',
                    'guard_name' =>   'api',
                ],

            )
        );
    }
}
