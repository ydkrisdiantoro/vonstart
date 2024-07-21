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
    public function goLogin($email, $password, $pretend = false)
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
            return $this->directLogin($user);
        }

        return Auth::check();
    }

    /**
     * This user safe to log in
     * @param collection $user
     */
    public function directLogin(User $user)
    {
        if (sizeof($user->userRoles) > 0) {
            try {
                $firstRole = $user->userRoles->sortBy('order')->first();
                $mapRoles = $user->userRoles->mapWithKeys(function($item){
                    return [
                        $item->role_id => $item->role
                    ];
                });

                $this->changeRole($firstRole->role_id, $user);
                $this->useYear();

                $userArray = $user->toArray();
                unset($userArray['roles']);

                Session::put('roles', $mapRoles->toArray());
                Session::put('user', $userArray);
                Session::save();

                Auth::login($user);
            } catch (\Throwable $th) {
                if(App::environment() == 'local'){
                    dd($th);
                } else{
                    return view('errors.500');
                }
            }
        } else{
            return view('errors.403');
        }
    }

    protected function useYear()
    {
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
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login.read');
    }

    public function changeRole($roleId)
    {
        try {
            $menuGroups = [];
            $menus = [];
            $routeMenus = [];
            $notification = [];
            $accessMenus = [];
            $roleMenus = RoleMenu::where('role_id', $roleId)
                ->whereHas('menu', function($query){
                    $query->orderBy('order', 'asc');
                })
                ->where(function($q){
                    $q->where('is_read', true);
                    $q->orWhere('is_create', true);
                    $q->orWhere('is_update', true);
                    $q->orWhere('is_delete', true);
                    $q->orWhere('is_validate', true);
                })
                ->with([
                    'menu' => function($query){
                        $query->select('id', 'menu_group_id', 'name', 'icon', 'route', 'cluster', 'order', 'is_show');
                        $query->with(['menuGroup' => function($query){
                            $query->select('id', 'name', 'order');
                        }]);
                    },
                    'notification' => function($query){
                        $query->where('is_read', false);
                    }
                ])
                ->get();
    
            $notifTotal = 0;
            foreach($roleMenus as $roleMenu){
                $menusArray = $roleMenu->menu->toArray();
                unset($menusArray['menu_group']);
    
                $menuGroups[$roleMenu->menu->menu_group_id] = $roleMenu->menu->menuGroup->toArray();
                $menus[$roleMenu->menu->menu_group_id][$roleMenu->menu_id] = $menusArray;
                $routeMenus[$roleMenu->menu->route] = $menusArray;
                
                $notifCount = $roleMenu->notification->count();
                $notifTotal += $notifCount;
                $notification[$roleMenu->menu->route]['color'] = 'primary';
                $notification[$roleMenu->menu->route]['text'] = $notifCount;
                $notification[$roleMenu->menu->route]['datas'] = $roleMenu->notification->toArray();

                $accessMenus[$roleMenu->menu->route] = [
                    'is_create' => $roleMenu->is_create,
                    'is_read' => $roleMenu->is_read,
                    'is_update' => $roleMenu->is_update,
                    'is_delete' => $roleMenu->is_delete,
                    'is_validate' => $roleMenu->is_validate,
                ];
            }
    
            Session::has('active_role_id') ? Session::forget('active_role_id') : null;
            Session::put('active_role_id', $roleId);

            Session::has('menu_groups') ? Session::forget('menu_groups') : null;
            Session::put('menu_groups', $menuGroups);

            Session::has('menus') ? Session::forget('menus') : null;
            Session::put('menus', $menus);

            Session::has('active_menu') ? Session::forget('active_menu') : null;
            Session::put('active_menu', 'dashboard');

            Session::has('notification') ? Session::forget('notification') : null;
            Session::put('notification', $notification);

            Session::has('route_menus') ? Session::forget('route_menus') : null;
            Session::put('route_menus', $routeMenus);

            Session::has('access_menus') ? Session::forget('access_menus') : null;
            Session::put('access_menus', $accessMenus);
            Session::save();

            return ['success' => true];
        } catch (\Throwable $th) {
            //throw $th;
            if(App::environment() == 'local'){
                dd($th);
            }
        }

        return false;
    }

    public function refresh()
    {
        $session = session()->all();
        $roleId = $session['active_role_id'];
        $user = User::with('userRoles.role')->findOrFail(Auth::user()->id);
        $roles = $user->userRoles->mapWithKeys(function($item){
            return [
                $item->role_id => $item->role->toArray()
            ];
        });
        $user = $user->toArray();
        unset($user['userRoles']);

        Session::put('user', $user);
        Session::put('roles', $roles->toArray());
        $this->changeRole($roleId);

        return redirect()->back();
    }
}
