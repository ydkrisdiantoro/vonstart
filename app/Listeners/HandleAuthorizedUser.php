<?php

namespace App\Listeners;

use App\Events\AuthorizedUser;
use App\Models\MenuGroup;
use App\Services\MenuGroupService;
use App\Services\RoleMenuService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class HandleAuthorizedUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuthorizedUser $event): void
    {
        $user = $event->user;
        $roleId = @$event->roleId;
        $userRoles = $user->userRoles->sortBy('order');
        $role = $userRoles->first();
        if ($roleId) {
            $role = $userRoles->where('role_id', $roleId)->first();
        }
        $menus = (new RoleMenuService)->getMenusByRole($role->role_id);
        $menuGroups = (new MenuGroupService)->getMenuGroupIn($menus->pluck('menu_group_id'));
        $activeMenu = 'dashboard';
        if(Session::has('active_menu')){
            $activeMenu = Session::get('active_menu');
        }

        $data = [
            'roles' => $userRoles->keyBy('role_id')->toArray(),
            'role' => $role->toArray(),
            'menus' => $menus->keyBy('route')->toArray(),
            'sidebar' => $menus->keyBy('route')->groupBy('menu_group_id')->toArray(),
            'menu_groups' => $menuGroups->keyBy('id')->toArray(),
            'active_menu' => $activeMenu,
            'user' => $user->toArray(),
        ];

        Session::forget(array_keys($data));
        foreach($data as $key => $val){
            Session::put($key, $val);
        }
        Session::save();
    }
}
