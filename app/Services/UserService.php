<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'name' => ['required','string'],
            'email' => ['required','unique:users,email'],
            'photo' => ['nullable','image'],
            'password' => ['required','string'],
            'confirm_password' => ['required','string','same:password'],
        ];
    }

    /**
     * Get User
     * @param uuid $userId optional
     * @return model_instance from find() or get()
     */
    public function getUser($userId = null, $paginate = null)
    {
        if($userId != null){
            $data = User::find($userId);
        } else{
            if ($paginate === null) {
                $data = User::get();
            } else{
                $data = User::paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create User
     * @param array $datas
     * @return model_instance return from save()
     */
    public function create($datas)
    {
        $users = (new User)->fill($datas);
        if($users->save()){
            return $users;
        } else{
            return false;
        }
    }

    /**
     * Update User by Id
     * @param uuid $userId
     * @param array $datas
     * @return model_instance return from update()
     */
    public function update($userId, $datas)
    {
        if($datas['password'] === null){
            unset($datas['password'], $datas['confirm_password']);
        }
        return User::find($userId)->update($datas);
    }

    /**
     * Delete User
     * @param uuid $userId
     * @return model_instance from delete()
     */
    public function delete($userId)
    {
        return User::find($userId)->delete();
    }
}
