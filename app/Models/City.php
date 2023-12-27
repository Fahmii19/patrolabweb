<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'city';

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
    public function projects()
    {
        return $this->hasMany(ProjectModel::class, 'city_id');
    }
}

