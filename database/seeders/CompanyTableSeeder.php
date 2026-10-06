<?php

namespace Database\Seeders;


use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Dipokhalder\Settings\Facades\Settings;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::group('company')->set([
            'company_name'         => 'FoodAlex - Restaurant Food Ordering & Delivery App',
            'company_email'        => 'info@food-alex.kesug.com',
            'company_phone'        => '0123456789',
            'company_website'      => 'https://food-alex.kesug.com',
            'company_city'         => 'Alexandria',
            'company_state'        => 'Alexandria',
            'company_country_code' => 'EG',
            'company_zip_code'     => '21500',
            'company_address'      => 'Alexandria, Egypt'
        ]);

        $envService = new EnvEditor();
        $envService->addData([
            'APP_NAME' => "FoodKing - Restaurant Food Ordering & Delivery App"
        ]);
        Artisan::call('optimize:clear');
    }
}
