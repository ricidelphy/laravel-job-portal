<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FreelancerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('freelancer_profiles')->insert(
            array(
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 1,
                    'user_id'       => 3,
                    'birthplace'    => 'Aceh',
                    'birthdate'     => '1989-08-10',
                    'phone_number'  => '085277663642',
                    'gender'        => 1,
                    'address'       => 'Lhokseumawe, Aceh',
                    'resume_file'   => 'RESUME-demo.pdf',

                ],
            )
        );
    }
}
