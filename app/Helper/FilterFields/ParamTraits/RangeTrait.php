<?php

namespace App\Helper\FilterFields\ParamTraits;

trait RangeTrait{

    /**
     * Пример
     * ['title'=>'Именование поля','step'=>0.2]
     */
    static $param  = [];

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
        return [
            '_name' => $fieldName,
            'title' => !empty(self::$param['title']) ? self::$param['title'] : '',
            '_fieldProps' => [
                'step' => !empty(self::$param['step']) ? self::$param['step'] : 1,
                'interval' => $data['list'],
                'availableSelection' => $data['value'],
                'name' => $fieldName
            ],
            '_type' => 'range',
            'value' => $data['request'] ? $data['request'] : $data['list'],
            'data' => $data['list'],
        ];
    }
}
