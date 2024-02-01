<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['ip_id', 'date', 'time'];

    public function ip()
    {
        return $this->belongsTo(Ip::class);
    }
}
