<?php

namespace App\Helper\FilterFields;

use App\Helper\Generator;
use Illuminate\Support\Str;

class GeneratorField extends Generator{

    protected $fieldArray;

    public function __construct(array $fieldArray) {
        $this->fieldArray = $fieldArray;
    }

    public function getFilterArray(){
        return $this->fieldArray;
    }

    public function apply($data) {
        $objectData = $this->applyObjectsFromRequest($data);
        return $objectData;
    }

    private function  applyObjectsFromRequest($data) {
        $filterData = [];
        foreach ($this->fieldArray as $fieldName) {

            $object = $this->createFilterObject($fieldName);
            if($this->isValidObject($object) && isset($data[$fieldName])) {
                if(empty($data[$fieldName]['list'])) continue;
                $filterData = array_merge($filterData, [$object::apply($fieldName, $data[$fieldName])]);
            }
        }

        return $filterData;
    }

}
