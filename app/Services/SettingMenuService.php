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
            return SettingMenu::where('status', Status::ACTIVE)->orderBy('priority', 'desc')->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }
}
