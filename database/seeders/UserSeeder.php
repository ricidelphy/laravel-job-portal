<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            array(
                [
                    'uuid'       => Uuid::uuid4()->toString(),
                    'id'         => 1,
                    'name'       => 'Administrator',
                    'email'      => 'admin@gmail.com',
                    'password'   => Hash::make('123456'),
                    'status'     => 1,
                ],
                [
                    'uuid'       => Uuid::uuid4()->toString(),
                    'id'         => 2,
                    'name'       => 'Employeer',
                    'email'      => 'employeer@gmail.com',
                    'password'   => Hash::make('123456'),
                    'status'     => 1,
                ],
                [
                    'uuid'       => Uuid::uuid4()->toString(),
                    'id'         => 3,
                    'name'       => 'Freelancer',
                    'email'      => 'freelancer@gmail.com',
                    'password'   => Hash::make('123456'),
                    'status'     => 1,
                ],



            )
        );
    }
}
