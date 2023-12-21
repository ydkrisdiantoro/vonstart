<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'code' => ['required','string'],
            'name' => ['required','string'],
            'icon' => ['required','string'],
            'order' => ['required','integer'],
        ];
    }

    /**
     * Get Role
     * @param uuid $roleId optional
     * @return model_instance from find() or get()
     */
    public function getRole($roleId = null)
    {
        if($roleId != null){
            $data = Role::find($roleId);
        } else{
            $data = Role::get();
        }
        return $data;
    }

    /**
     * Create Role
     * @param array $datas
     * @return model_instance return from save()
     */
    public function create($datas)
    {
        $roles = (new Role)->fill($datas);
        if($roles->save()){
            return $roles;
        } else{
            return false;
        }
    }

    /**
     * Update Role by Id
     * @param uuid $roleId
     * @param array $datas
     * @return model_instance return from update()
     */
    public function update($roleId, $datas)
    {
        return Role::find($roleId)->update([$datas]);
    }

    /**
     * Delete Role
     * @param uuid $roleId
     * @return model_instance from delete()
     */
    public function delete($roleId)
    {
        return Role::find($roleId)->delete();
    }
}
