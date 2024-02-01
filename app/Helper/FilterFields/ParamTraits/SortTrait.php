<?php

namespace App\Helper\FilterFields\ParamTraits;

trait SortTrait{

    /**
     * Пример
     * ['title'=>'Именование поля','step'=>0.2]
     */
    static $param  = [];
    static $defaultData = [];

    abstract static function setData();

    /**
     * Undocumented function
     *
     * @param string $fieldName
     * @param object $data

     * @return array
     */

    public static function apply($fieldName, $data)
    {
        self::setData();

        return $data['value'];
    }
}
