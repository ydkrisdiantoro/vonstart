<?php

namespace App\Services;

use App\Models\MenuGroup;

class MenuGroupService
{

    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'name' => ['required','string'],
            'order' => ['required','integer'],
        ];
    }

    /**
     * Get MenuGroup
     * @param uuid $menuGroupId optional
     * @return collection from find() or get()
     */
    public function getMenuGroup($menuGroupId = null, $paginate = null)
    {
        if($menuGroupId != null){
            $data = MenuGroup::withCount('menus')->orderBy('order', 'asc')->find($menuGroupId);
        } else{
            if ($paginate === null) {
                $data = MenuGroup::withCount('menus')->orderBy('order', 'asc')->get();
            } else{
                $data = MenuGroup::withCount('menus')->orderBy('order', 'asc')->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create MenuGroup
     * @param array $datas
     * @return collection return from save()
     */
    public function create($datas)
    {
        $menuGroups = (new MenuGroup)->fill($datas);
        if($menuGroups->save()){
            return $menuGroups;
        } else{
            return false;
        }
    }

    /**
     * Update MenuGroup by Id
     * @param uuid $menuGroupId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($menuGroupId, $datas)
    {
        return MenuGroup::find($menuGroupId)->update($datas);
    }

    /**
     * Delete MenuGroup
     * @param uuid $menuGroupId
     * @return collection from delete()
     */
    public function delete($menuGroupId)
    {
        return MenuGroup::find($menuGroupId)->delete();
    }

    public function getMenuGroupIn($listMenuGroupId)
    {
        return MenuGroup::whereIn('id', $listMenuGroupId)
            ->orderBy('order', 'asc')
            ->select('id', 'order', 'name')
            ->get();
    }
}
