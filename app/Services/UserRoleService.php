<?php

namespace App\Services;

use App\Models\UserRole;

class UserRoleService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'role_id' => ['required','string','max:36'],
            'user_id' => ['required','string','max:36'],
        ];
    }

    /**
     * Get UserRole
     * @param uuid $userRoleId optional
     * @return model_instance from find() or get()
     */
    public function getUserRole($userRoleId = null)
    {
        if($userRoleId != null){
            $data = UserRole::find($userRoleId);
        } else{
            $data = UserRole::get();
        }
        return $data;
    }

    /**
     * Create UserRole
     * @param array $datas
     * @return model_instance return from save()
     */
    public function create($datas)
    {
        $userRoles = (new UserRole)->fill($datas);
        if($userRoles->save()){
            return $userRoles;
        } else{
            return false;
        }
    }

    /**
     * Update UserRole by Id
     * @param uuid $userRoleId
     * @param array $datas
     * @return model_instance return from update()
     */
    public function update($userRoleId, $datas)
    {
        return UserRole::find($userRoleId)->update([$datas]);
    }

    /**
     * Delete UserRole
     * @param uuid $userRoleId
     * @return model_instance from delete()
     */
    public function delete($userRoleId)
    {
        return UserRole::find($userRoleId)->delete();
    }
}
