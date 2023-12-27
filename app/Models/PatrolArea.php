<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolArea extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'patrol_area';

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function gate()
    {
        return $this->hasMany(Gate::class, 'patrol_area_id');
    }
}
