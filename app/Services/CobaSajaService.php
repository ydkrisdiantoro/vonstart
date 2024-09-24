<?php

namespace App\Services;

use App\Models\CobaSaja;

class CobaSajaService
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
     * Get CobaSaja
     * @param uuid $cobaSajaId optional
     * @return collection from find() or get()
     */
    public function getCobaSaja($cobaSajaId = null, $paginate = null)
    {
        if($cobaSajaId != null){
            $data = CobaSaja::with(['menuGroup'])->find($cobaSajaId);
        } else{
            if ($paginate === null) {
                $data = CobaSaja::with(['menuGroup'])->get();
            } else{
                $data = CobaSaja::with(['menuGroup'])->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create CobaSaja
     * @param array $datas
     * @return collection|false return from save()
     */
    public function create($datas)
    {
        $createData = (new CobaSaja)->fill($datas);
        if($createData->save()){
            return $createData;
        } else{
            return false;
        }
    }

    /**
     * Update CobaSaja by Id
     * @param uuid $cobaSajaId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($cobaSajaId, $datas)
    {
        return CobaSaja::find($cobaSajaId)->update($datas);
    }

    /**
     * Delete CobaSaja
     * @param uuid $cobaSajaId
     * @return collection from delete()
     */
    public function delete($cobaSajaId)
    {
        return CobaSaja::find($cobaSajaId)->delete();
    }
}
