<?php

namespace App\Services;

use App\Models\Menus;

class MenusService
{
    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'menu_group_id' => 'required|string|min:36|max:36',
            'name' => 'required|string',
            'icon' => 'required|string',
            'route' => 'required|string',
            'cluster' => 'nullable|string',
            'is_show' => 'required|numeric',
            'order' => 'required|numeric',
        ];
    }

    /**
     * Get Menus
     * @param uuid $menusId optional
     * @return collection from find() or get()
     */
    public function getMenus($menusId = null, $paginate = null)
    {
        if($menusId != null){
            $data = Menus::with(['menuGroup'])->find($menusId);
        } else{
            if ($paginate === null) {
                $data = Menus::with(['menuGroup'])->get();
            } else{
                $data = Menus::with(['menuGroup'])->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create Menus
     * @param array $datas
     * @return collection|false return from save()
     */
    public function create($datas)
    {
        $createData = (new Menus)->fill($datas);
        if($createData->save()){
            return $createData;
        } else{
            return false;
        }
    }

    /**
     * Update Menus by Id
     * @param uuid $menusId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($menusId, $datas)
    {
        return Menus::find($menusId)->update($datas);
    }

    /**
     * Delete Menus
     * @param uuid $menusId
     * @return collection from delete()
     */
    public function delete($menusId)
    {
        return Menus::find($menusId)->delete();
    }
}
