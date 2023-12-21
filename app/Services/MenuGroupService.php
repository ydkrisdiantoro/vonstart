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
     * @return model_instance from find() or get()
     */
    public function getMenuGroup($menuGroupId = null)
    {
        if($menuGroupId != null){
            $data = MenuGroup::find($menuGroupId);
        } else{
            $data = MenuGroup::get();
        }
        return $data;
    }

    /**
     * Create MenuGroup
     * @param array $datas
     * @return model_instance return from save()
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
     * @return model_instance return from update()
     */
    public function update($menuGroupId, $datas)
    {
        return MenuGroup::find($menuGroupId)->update([$datas]);
    }

    /**
     * Delete MenuGroup
     * @param uuid $menuGroupId
     * @return model_instance from delete()
     */
    public function delete($menuGroupId)
    {
        return MenuGroup::find($menuGroupId)->delete();
    }
}
