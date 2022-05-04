<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use DB;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Rfc4122\UuidV1;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            array(
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 1,
                    'category_name' => 'Software Engineering',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 2,
                    'category_name' => 'Businees Development',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 3,
                    'category_name' => 'Marketing',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 4,
                    'category_name' => 'Design',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 5,
                    'category_name' => 'Hospitality',
                ],
                [
                    'uuid'          => Uuid::uuid4()->toString(),
                    'id'            => 6,
                    'category_name' => 'Travel',
                ],
            )
        );
    }
}
