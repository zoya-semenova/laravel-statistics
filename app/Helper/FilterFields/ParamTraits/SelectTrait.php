<?php

namespace App\Helper\FilterFields\ParamTraits;

trait SelectTrait{

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

        $value = [];
        if(!empty(self::$defaultData)){
            $value = self::defaultData();
            $data['list'] = array_merge(self::defaultData(), $data['list']);
        }
        if($data['request']){
            $listCollection = collect($data['list']);
            $value = array_values($listCollection->whereIn('_id',$data['request'])->all());
        }

        return [
            '_name' => $fieldName,
            'title' => !empty(self::$param['title']) ? self::$param['title'] : '',
            '_type' => 'select',
            '_fieldProps' => [
                'name' => $fieldName,
                'options' => $data['list'],
            ],
            'data' => $data['list'],
            'value' => $value,
        ];
    }
}
