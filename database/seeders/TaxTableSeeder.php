<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\TaxType;
use App\Enums\Status;
use App\Models\Tax;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [
            [
                'id'       => 1,
                'name'     => 'بدون ضريبة (معفى)',
                'code'     => 'VAT-0',
                'tax_rate' => 0,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 2,
                'name'     => 'ضريبة القيمة المضافة (VAT 14%)',
                'code'     => 'VAT-14%',
                'tax_rate' => 14,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 3,
                'name'     => 'ضريبة مخفضة (VAT 5%)',
                'code'     => 'VAT-5%',
                'tax_rate' => 5,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 4,
                'name'     => 'ضريبة مبيعات (VAT 10%)',
                'code'     => 'VAT-10%',
                'tax_rate' => 10,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 5,
                'name'     => 'خدمة صالة (Service 12%)',
                'code'     => 'SVC-12%',
                'tax_rate' => 12,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
        ];

        foreach ($taxes as $tax) {
            Tax::updateOrCreate(
                ['id' => $tax['id']],
                $tax
            );
        }
    }
}
