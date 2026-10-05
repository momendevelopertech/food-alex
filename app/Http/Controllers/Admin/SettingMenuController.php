<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Services\SettingMenuService;
use App\Http\Resources\SettingMenuResource;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SettingMenuController extends AdminController implements HasMiddleware
{
    public SettingMenuService $settingMenuService;

    public function __construct(SettingMenuService $settingMenuService)
    {
        parent::__construct();
        $this->settingMenuService = $settingMenuService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:settings', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            return SettingMenuResource::collection($this->settingMenuService->list());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
