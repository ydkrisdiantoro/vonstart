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
     * @return model_instance from find() or get()
     */
    public function getRoleMenu($roleMenuId = null)
    {
        if($roleMenuId != null){
            $data = RoleMenu::find($roleMenuId);
        } else{
            $data = RoleMenu::get();
        }
        return $data;
    }

    /**
     * Create RoleMenu
     * @param array $datas
     * @return model_instance return from save()
     */
    public function create($datas)
    {
        $roleMenus = (new RoleMenu)->fill($datas);
        if($roleMenus->save()){
            return $roleMenus;
        } else{
            return false;
        }
    }

    /**
     * Update RoleMenu by Id
     * @param uuid $roleMenuId
     * @param array $datas
     * @return model_instance return from update()
     */
    public function update($roleMenuId, $datas)
    {
        return RoleMenu::find($roleMenuId)->update([$datas]);
    }

    /**
     * Delete RoleMenu
     * @param uuid $roleMenuId
     * @return model_instance from delete()
     */
    public function delete($roleMenuId)
    {
        return RoleMenu::find($roleMenuId)->delete();
    }
}
