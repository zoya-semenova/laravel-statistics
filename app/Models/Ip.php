<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use HasFactory;

    protected $fillable = ['ip'];

    public function statistics() {
        return $this->hasMany(Statistic::class, 'ip_id');
    }
}
