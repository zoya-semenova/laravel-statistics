<?php

namespace App\Helper\FieldsData;

use App\Helper\FunctionHelper;
use App\Helper\Generator;

class GeneratorFieldData extends Generator{

    public function apply($fields, $request, $defaultData, $selectData = []) {
        $objectData = $this->applyObjectsFromRequest($fields, $request, $defaultData, $selectData);
        return $objectData;
    }

    private function  applyObjectsFromRequest($fields, $request, $defaultData, $selectData) {
        $filterData = [];

        $defaultData->each(function ($item, $key) use($selectData) {
            if(!empty($item->flat_id)){
                if($selectData->contains('id', $item->flat_id)){
                    $item->active = true;
                }else{
                    $item->active = false;
                }
            }

        });


        foreach ($fields as $fieldName) {

            $object = $this->createFilterObject($fieldName);
            if($this->isValidObject($object)) {
                $select = [
                    'value'=>$object::apply($selectData),
                    'list'=>$object::apply($defaultData),
                    'request'=>$request->input($fieldName) ? $request->input($fieldName) : []
                ];
                $filterData = array_merge($filterData, [$fieldName=>$select]);
            }
        }

        return FunctionHelper::arrayValues($filterData);
    }

}
