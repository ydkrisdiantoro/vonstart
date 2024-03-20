<?php

namespace App\Services;

use App\Models\User;
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
     * @return collection from find() or get()
     */
    public function getUserRole($userRoleId = null, $paginate = null, $userId = null)
    {
        if($userRoleId != null){
            $data = UserRole::with(['role', 'user'])
                ->whereHas('role')
                ->whereHas('user')
                ->find($userRoleId);
        } else{
            $data = UserRole::with(['role'])->whereHas('role');
            $data = $data->whereHas('user', function($query) use($userId){
                if($userId !== null){
                    $query->where('user_id', $userId);
                }
            });

            if ($paginate === null) {
                $data = $data->get();
            } else{
                $data = $data->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create UserRole
     * @param array $datas
     * @return collection return from save()
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
     * @return collection return from update()
     */
    public function update($userRoleId, $datas)
    {
        return UserRole::find($userRoleId)->update($datas);
    }

    /**
     * Delete UserRole
     * @param uuid $userRoleId
     * @return collection from delete()
     */
    public function delete($userRoleId)
    {
        return UserRole::find($userRoleId)->delete();
    }

    public function findUser($userId){
        return User::find($userId);
    }
}
