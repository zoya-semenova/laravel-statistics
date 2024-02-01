<?php

namespace App\Helper\FilterFields;

use Illuminate\Database\Query\Builder;

/**
 * Интерфейс для формирования каждого отдельного фильтра.
 *
 */
interface FilterField{
    public static function apply($fieldName, $data);
}
