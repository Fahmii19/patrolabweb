<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'rounds';

    public function patrol_area()
    {
        return $this->belongsTo(PatrolArea::class, 'patrol_area_id', 'id');
    }

    public function checkpoint()
    {
        return $this->hasMany(CheckPoint::class, 'round_id', 'id');
    }
}
