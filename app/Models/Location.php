<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'responsible_name', 'responsible_phone'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
