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
     * @return model_instance from find() or get()
     */
    public function getMenu($menuId = null)
    {
        if($menuId != null){
            $data = Menu::find($menuId);
        } else{
            $data = Menu::get();
        }
        return $data;
    }

    /**
     * Create Menu
     * @param array $datas
     * @return model_instance|false return from save()
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
     * @return model_instance return from update()
     */
    public function update($menuId, $datas)
    {
        return Menu::find($menuId)->update([$datas]);
    }

    /**
     * Delete Menu
     * @param uuid $menuId
     * @return model_instance from delete()
     */
    public function delete($menuId)
    {
        return Menu::find($menuId)->delete();
    }
}
