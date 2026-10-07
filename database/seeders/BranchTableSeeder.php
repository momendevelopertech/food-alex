<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::updateOrCreate(
            ['id' => 1],
            [
                'name'      => 'فرع الإسكندرية (الرئيسي)',
                'email'     => 'alex@food-alex.kesug.com',
                'phone'     => '0123456789',
                'latitude'  => 31.2000924,
                'longitude' => 29.9187382,
                'zone'      => json_encode([
                    ['lat' => 31.220, 'lng' => 29.900],
                    ['lat' => 31.225, 'lng' => 29.940],
                    ['lat' => 31.180, 'lng' => 29.950],
                    ['lat' => 31.175, 'lng' => 29.910],
                ]),
                'city'      => 'الإسكندرية',
                'state'     => 'الإسكندرية',
                'zip_code'  => '21500',
                'address'   => 'سموحة، أمام جرين بلازا، الإسكندرية، مصر',
                'status'    => Status::ACTIVE,
            ]
        );
    }
}