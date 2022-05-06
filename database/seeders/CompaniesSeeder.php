<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert(
            array(
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 1,
                    'user_id'       => 2,
                    'company_name'  => 'PT ABCDEFGHI',
                    'company_logo'  => 'no-image.png',
                    'about'         => 'lorem ipsum dolor sit amet consectetur adipiscing elit',
                    'website'       => 'www.abcdefghi.com',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 2,
                    'user_id'       => 1,
                    'company_name'  => 'PT XYZ',
                    'company_logo'  => 'no-image.png',
                    'about'         => 'lorem ipsum dolor sit amet consectetur adipiscing elit',
                    'website'       => 'www.xyz.id',
                ],

            )
        );
    }
}
