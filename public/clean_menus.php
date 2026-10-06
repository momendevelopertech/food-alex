<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use App\Models\SettingMenu;
use Database\Seeders\MenuTableSeeder;
use Database\Seeders\SettingMenuTableSeeder;

header('Content-Type: text/plain; charset=utf-8');

echo "=== FoodAlex Menu & Setting Cleaner ===\n";

try {
    echo "Current menus count: " . Menu::count() . "\n";
    echo "Current setting_menus count: " . SettingMenu::count() . "\n";

    echo "Running MenuTableSeeder...\n";
    $menuSeeder = new MenuTableSeeder();
    $menuSeeder->run();
    echo "New menus count: " . Menu::count() . "\n";

    echo "Running SettingMenuTableSeeder...\n";
    $settingSeeder = new SettingMenuTableSeeder();
    $settingSeeder->run();
    echo "New setting_menus count: " . SettingMenu::count() . "\n";

    echo "SUCCESS: Database menus and settings cleaned and re-seeded cleanly!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
