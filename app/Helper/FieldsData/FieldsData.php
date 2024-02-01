<?php

namespace App\Helper\FieldsData;

/**
 * Интерфейс для формирования каждого отдельного фильтра.
 *
 */
interface FieldsData{
    public static function apply($data);
}
