<?php

namespace App\Helper\FilterFields\ParamTraits;

trait DefaultParamTrait{

    /**
     * Пример
     * ['title'=>'Именование поля','step'=>0.2]
     */
    static $defaultData  = [];

    public static function defaultData(){
        return [array_merge(['_id'=>"0"], self::$defaultData)];
    }

}
