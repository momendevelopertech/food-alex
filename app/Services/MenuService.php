<?php

namespace App\Services;

use Exception;
use App\Models\Menu;
use App\Libraries\AppLibrary;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Libraries\QueryExceptionLibrary;
use Spatie\Permission\Models\Permission;

class MenuService
{
    /**
     * @throws Exception
     */
    public function menu(Role $role) : array
    {
        try {
            try {
                if (Menu::count() > 35) {
                    \Illuminate\Support\Facades\DB::statement("DELETE m1 FROM menus m1 INNER JOIN menus m2 WHERE m1.id > m2.id AND m1.url = m2.url AND m1.url != '#'");
                    \Illuminate\Support\Facades\DB::statement("DELETE m1 FROM menus m1 INNER JOIN menus m2 WHERE m1.id > m2.id AND m1.language = m2.language AND m1.url = '#'");
                }
            } catch (\Throwable $th) {
                // Ignore if DB query fails
            }

            $rawMenus        = Menu::orderBy('id', 'asc')->get()->toArray();
            $seenKeys        = [];
            $menus           = [];
            foreach ($rawMenus as $m) {
                $dedupKey = ($m['url'] !== '#' && !empty($m['url'])) ? $m['url'] : ('parent_' . $m['language']);
                if (!isset($seenKeys[$dedupKey])) {
                    $seenKeys[$dedupKey] = true;
                    $menus[] = $m;
                }
            }
            $permissions     = Permission::get();
            $rolePermissions = Permission::join(
                "role_has_permissions",
                "role_has_permissions.permission_id",
                "=",
                "permissions.id"
            )->where("role_has_permissions.role_id", $role->id)->get()->pluck('name', 'id');
            $permissions     = AppLibrary::permissionWithAccess($permissions, $rolePermissions);
            $permissions     = AppLibrary::pluck($permissions, 'obj', 'url');
            return AppLibrary::numericToAssociativeArrayBuilder(AppLibrary::menu($menus, $permissions));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }
}
