<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Validation\Rule;

class MenuService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'menu_group_id' => ['required','string','max:36'],
            'name' => ['required','string'],
            'icon' => ['required','string'],
            'route' => ['required','string'],
            'is_show' => ['required','integer', Rule::in([0, 1])],
            'cluster' => ['nullable','string'],
            'order' => ['required','integer'],
        ];
    }

    /**
     * Get Menu
     * @param uuid $menuId optional
     * @return collection from find() or get()
     */
    public function getMenu($menuId = null, $paginate = null)
    {
        if($menuId != null){
            $data = Menu::with(['menuGroup'])
                ->whereHas('menuGroup')
                ->find($menuId);
        } else{
            if ($paginate === null) {
                $data = Menu::with(['menuGroup'])
                    ->whereHas('menuGroup')
                    ->get();
            } else{
                $data = Menu::with(['menuGroup'])
                    ->whereHas('menuGroup')
                    ->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create Menu
     * @param array $datas
     * @return collection|false return from save()
     */
    public function create($datas)
    {
        $menus = (new Menu)->fill($datas);
        if($menus->save()){
            return $menus;
        } else{
            return false;
        }
    }

    /**
     * Update Menu by Id
     * @param uuid $menuId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($menuId, $datas)
    {
        return Menu::find($menuId)->update($datas);
    }

    /**
     * Delete Menu
     * @param uuid $menuId
     * @return collection from delete()
     */
    public function delete($menuId)
    {
        return Menu::find($menuId)->delete();
    }
}
