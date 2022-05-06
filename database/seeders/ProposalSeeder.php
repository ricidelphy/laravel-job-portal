<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use DB;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposals')->insert(
            array(
                [
                    'uuid'                  => Uuid::uuid4()->toString(),
                    'id'                    => 1,
                    'user_id'               => 3,
                    'job_id'                => 1,
                    'status'                => 'send'
                ],


            )
        );
    }
}
