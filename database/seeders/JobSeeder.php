<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert(
            array(
                [
                    'uuid'                  => Uuid::uuid4()->toString(),
                    'id'                    => 1,
                    'user_id'               => 2,
                    'company_id'            => 1,
                    'category_id'           => 1,
                    'job_name'              => 'Full Stack Developer',
                    'job_description'       => 'Full Stack Developer Description',
                    'published'             => 1
                ],


            )
        );
    }
}
