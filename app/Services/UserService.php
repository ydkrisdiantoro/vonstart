<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
     * @return collection from find() or get()
     */
    public function getUser($userId = null, $paginate = null, $filters = null)
    {
        if($userId != null){
            $data = User::find($userId);
        } else{
            if ($paginate === null) {
                $data = User::with('userRoles.role')->get();
            } else{
                if ($filters) {
                    $data = User::with('userRoles.role');
                    foreach($filters as $column => $value){
                        if ($value) {
                            if ($column == 'name' || $column == 'email') {
                                $data = $data->where($column, 'like', '%'.$value.'%');
                            } elseif($column == 'role'){
                                $data = $data->whereRelation('userRoles', 'role_id', '=', $value);
                            } else{
                                $data = $data->where($column, $value);
                            }
                        }
                    }
                    $data = $data->paginate($paginate);
                } else{
                    $data = User::with('userRoles.role')->paginate($paginate);
                }
            }
        }
        return $data;
    }

    /**
     * Create User
     * @param array $datas
     * @return collection return from save()
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
     * @return collection return from update()
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
     * @return collection from delete()
     */
    public function delete($userId)
    {
        return User::find($userId)->delete();
    }

    /**
     * Get User
     * @param uuid $userId optional
     * @return collection from find() or get()
     */
    public function getUserPretend($keyword)
    {
        $user = Auth::user();
        return User::where('id', '!=', $user->id)
            ->where(function($q) use($keyword){
                $q->where('email', 'like', '%'.$keyword.'%');
                $q->orWhere('name', 'like', '%'.$keyword.'%');
            })
            ->limit(10)
            ->with('userRoles.role')
            ->get();
    }

    public function findUser($id = null, $email = null)
    {
        if ($id !== null || $email !== null) {
            $column = 'id';
            if ($email) {
                $column = 'email';
            }
            $user = User::select('id', 'name','email','phone', 'password')
                ->where($column, $id ?? $email)
                ->with([
                    'userRoles' => function($query){
                        $query->select(
                            'user_roles.id',
                            'user_roles.role_id',
                            'user_id',
                            'roles.code',
                            'roles.name',
                            'roles.icon',
                            'roles.order'
                        );
                        $query->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id');
                    }])
                ->first();
        } else{
            $user = null;
        }

        return $user;
    }
}
