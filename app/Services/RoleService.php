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
     * @return collection from find() or get()
     */
    public function getRole($roleId = null, $paginate = null, $forSelect = false)
    {
        if($roleId != null){
            $data = Role::find($roleId);
        } else{
            if ($forSelect) {
                $data = Role::pluck('name', 'id');
            } elseif ($paginate === null) {
                $data = Role::get();
            } else{
                $data = Role::paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create Role
     * @param array $datas
     * @return collection return from save()
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
     * @return collection return from update()
     */
    public function update($roleId, $datas)
    {
        return Role::find($roleId)->update($datas);
    }

    /**
     * Delete Role
     * @param uuid $roleId
     * @return collection from delete()
     */
    public function delete($roleId)
    {
        return Role::find($roleId)->delete();
    }
}
