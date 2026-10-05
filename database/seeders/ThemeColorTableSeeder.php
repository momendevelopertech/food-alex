<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dipokhalder\Settings\Facades\Settings;

class ThemeColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::group('theme')->set([
            'theme_primary_color' => "#FF006B",
        ]);
    }
}
