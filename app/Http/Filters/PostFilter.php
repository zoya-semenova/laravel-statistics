<?php
namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends QueryFilter
{
    /**
     * @param string $mask
     */
    public function mask(string $mask)
    {
        $this->builder->whereHas('ip', function($q) use($mask)
        {
            $q->whereRaw("ip <<= inet '$mask'");
        });
    }

    /**
     * @param string $ip
     */
    public function ip(string $ip)
    {
        $this->builder->whereHas('ip', function($q) use($ip)
        {
            $q->where('ip', '=', $ip);
        });
    }

    /**
     * @param string $date
     */
    public function dateFrom(string $date)
    {
        $this->builder->where('date', '>=', $date);
    }

    /**
     * @param string $date
     */
    public function dateTo(string $date)
    {
        $this->builder->where('date', '<=', $date);
    }
}