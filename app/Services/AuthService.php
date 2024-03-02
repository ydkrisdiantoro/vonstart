<?php

namespace App\Services;

use App\Models\RoleMenu;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthService
{
    /**
     * Login Process
     * @param string $email
     * @param string $password
     * @return boolean true if logged in
     */
    public function goLogin($email, $password)
    {
        $user = (new User)->where('email', $email)
            ->select('id', 'name','email','phone', 'password')
            ->with(['userRoles' => function($query){
                $query->select('id', 'role_id', 'user_id');
                $query->with(['role' => function($query){
                    $query->select('id', 'code', 'name', 'icon', 'order');
                }]);
            }])
            ->first();

        $hashedPassword = $user->password ?? null;

        if($hashedPassword !== null && Hash::check($password, $hashedPassword)){
            $firstRole = $user->userRoles->first();
            if ($firstRole) {
                try {
                    $mapRoles = $user->userRoles->mapWithKeys(function($item){
                        return [
                            $item->role_id => $item->role
                        ];
                    });
    
                    $menuGroups = [];
                    $menus = [];
                    $routeMenus = [];
                    $notification = [];
                    $accessMenus = [];
                    $roleMenus = RoleMenu::where('role_id', $firstRole->role_id)
                        ->whereHas('menu', function($query){
                            $query->orderBy('order', 'asc');
                            $query->where('is_show', true);
                        })
                        ->with(['menu' => function($query){
                            $query->select('id', 'menu_group_id', 'name', 'icon', 'route', 'cluster', 'order');
                            $query->with(['menuGroup' => function($query){
                                $query->select('id', 'name', 'order');
                            }]);
                        }])
                        ->get();
    
                    foreach($roleMenus as $roleMenu){
                        $menusArray = $roleMenu->menu->toArray();
                        unset($menusArray['menu_group']);

                        $menuGroups[$roleMenu->menu->menu_group_id] = $roleMenu->menu->menuGroup->toArray();
                        $menus[$roleMenu->menu->menu_group_id][$roleMenu->menu_id] = $menusArray;
                        $routeMenus[$roleMenu->menu->route] = $menusArray;
                        $notification[$roleMenu->menu->route]['color'] = 'info';
                        $notification[$roleMenu->menu->route]['text'] = null;
                        $accessMenus[$roleMenu->menu->route] = [
                            'is_create' => $roleMenu->is_create,
                            'is_read' => $roleMenu->is_read,
                            'is_update' => $roleMenu->is_update,
                            'is_delete' => $roleMenu->is_delete,
                            'is_validate' => $roleMenu->is_validate,
                        ];
                    }

                    $userArray = $user->toArray();
                    unset($userArray['roles']);

                    $useYear = config('vcontrol.year');
                    if($useYear){
                        $yearNow = date('Y');
                        $yearStart = config('vcontrol.year_start') ?? ($yearNow - 3);
                        $yearEnd = config('vcontrol.year_end') ?? ($yearNow + 1);
                        for($i = $yearEnd; $i >= $yearStart; $i--){
                            $years[] = $i;
                        }
                        Session::put('years', $years);
                        Session::put('active_year', $yearNow);
                    }

                    Session::put('active_role_id', $firstRole->role_id);
                    Session::put('roles', $mapRoles->toArray());
                    Session::put('menu_groups', $menuGroups);
                    Session::put('menus', $menus);
                    Session::put('user', $userArray);
                    Session::put('active_menu', 'dashboard');
                    Session::put('notification', $notification);
                    Session::put('route_menus', $routeMenus);
                    Session::put('access_menus', $accessMenus);
                    Session::save();

                    Auth::login($user);
                } catch (\Throwable $th) {
                    if(App::environment() == 'local'){
                        dd($th);
                    }
                }
            }
        }

        return Auth::check();
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login.read');
    }
}
