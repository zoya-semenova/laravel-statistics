<?php

namespace App\Helper\FieldsData\ParamTraits;

trait RangeTrait{

    public static function getData($data, $paramSelect){

        $min = null;
        $max = null;
        foreach($data AS $flat){
            if (!empty($flat->$paramSelect)) {
                $rangeData = self::addRange($min, $max, $flat->$paramSelect);
                $max = $rangeData['max'];
                $min = $rangeData['min'];
            }
        }
        return [floor($min), ceil($max)];
    }

    private static function addRange($methodMin, $methodMax, $data) {
        if (!isset($methodMin) && !isset($methodMax)) {
            $methodMin = $data;
            $methodMax = $data;
        }

        if (!empty($methodMin) && $methodMin > $data) {
            $methodMin =$data;
        } elseif (!empty($methodMax) && $methodMax < $data) {
            $methodMax = $data;
        }
        return ['min'=>$methodMin, 'max'=>$methodMax];
    }
}
