<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\SettingMenu;
use App\Enums\Status;
use App\Libraries\QueryExceptionLibrary;

class SettingMenuService
{
    /**
     * @throws Exception
     */
    public function list()
    {
        try {
            try {
                if (SettingMenu::count() > 30) {
                    \Illuminate\Support\Facades\DB::statement("DELETE s1 FROM setting_menus s1 INNER JOIN setting_menus s2 WHERE s1.id > s2.id AND s1.url = s2.url");
                }
            } catch (\Throwable $th) {
                // Ignore if DB statement fails
            }

            return SettingMenu::where('status', Status::ACTIVE)->orderBy('priority', 'desc')->get()->unique('url')->values();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }
}
