<?php

namespace App\Services;

use App\Models\RoleMenu;
use Illuminate\Validation\Rule;

class RoleMenuService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'menu_id' => ['required','string','max:36'],
            'role_id' => ['required','string','max:36'],
            'is_create' => ['required','integer', Rule::in([0, 1])],
            'is_read' => ['required','integer', Rule::in([0, 1])],
            'is_update' => ['required','integer', Rule::in([0, 1])],
            'is_delete' => ['required','integer', Rule::in([0, 1])],
            'is_validate' => ['required','integer', Rule::in([0, 1])],
        ];
    }

    /**
     * Get RoleMenu
     * @param uuid $roleMenuId optional
     * @return collection from find() or get()
     */
    public function getRoleMenu($roleMenuId = null, $paginate = null)
    {
        if($roleMenuId != null){
            $data = RoleMenu::with(['menu', 'role'])
                ->whereHas('menu')
                ->whereHas('role')
                ->find($roleMenuId);
        } else{
            if($paginate === null){
                $data = RoleMenu::with(['menu', 'role'])
                    ->whereHas('menu')
                    ->whereHas('role')
                    ->get();
            } else{
                $data = RoleMenu::with(['menu', 'role'])
                    ->whereHas('menu')
                    ->whereHas('role')
                    ->paginate($paginate);
            }
        }
        return $data;
    }

    // /**
    //  * Create RoleMenu
    //  * @param array $datas
    //  * @return collection return from save()
    //  */
    // public function create($datas)
    // {
    //     $roleMenus = (new RoleMenu)->fill($datas)->save();
    //     if($roleMenus){
    //         return $roleMenus;
    //     } else{
    //         return false;
    //     }
    // }

    /**
     * Update RoleMenu by Id
     * @param uuid $roleMenuId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($roleMenuId, $datas)
    {
        return RoleMenu::find($roleMenuId)->update($datas);
    }

    /**
     * Delete RoleMenu
     * @param uuid $roleMenuId
     * @return collection from delete()
     */
    public function delete($roleMenuId)
    {
        return RoleMenu::find($roleMenuId)->delete();
    }

    public function getRoleMenuByRoleId($roleId, $paginate = null, $map = false)
    {
        $data = RoleMenu::where('role_id', $roleId)
            ->leftJoin('');

        if($paginate){
            $data = $data->paginate($paginate);
        } else{
            $data = $data->get();
            if ($map) {
                $data = $data->mapWithKeys(function($item){
                    return [
                        $item->menu_id => $item
                    ];
                });
            }
        }

        return $data;
    }

    public function saveRoleMenu($req)
    {
        $roleId = $req['role_id'];

        try {
            foreach($req['menus'] as $menuId){
                $isCreate = in_array($menuId, $req['is_create'] ?? []);
                $isRead = in_array($menuId, $req['is_read'] ?? []);
                $isUpdate = in_array($menuId, $req['is_update'] ?? []);
                $isDelete = in_array($menuId, $req['is_delete'] ?? []);
                $isValidate = in_array($menuId, $req['is_validate'] ?? []);

                RoleMenu::updateOrCreate([
                    'role_id' => $roleId,
                    'menu_id' => $menuId,
                ], [
                    'is_create' => $isCreate,
                    'is_read' => $isRead,
                    'is_update' => $isUpdate,
                    'is_delete' => $isDelete,
                    'is_validate' => $isValidate,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        return true;
    }

    public function getMenusByRole($roleId)
    {
        return RoleMenu::where('role_id', $roleId)
            ->leftJoin('menus', 'menus.id', '=', 'role_menus.menu_id')
            ->where(function($q){
                $q->where('is_read', true);
                $q->orWhere('is_create', true);
                $q->orWhere('is_update', true);
                $q->orWhere('is_delete', true);
                $q->orWhere('is_validate', true);
                })
            ->orderBy('order', 'asc')
            ->select('menu_id', 'role_id', 'is_read', 'is_create', 'is_update', 'is_delete', 'is_validate', 'name', 'order', 'icon', 'route', 'is_show', 'cluster', 'menu_group_id')
            ->get();
    }
}
