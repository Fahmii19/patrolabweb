<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolAreaDescription extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'patrol_area_description';

    public function patrol_area()
    {
        return $this->belongsTo(PatrolArea::class, 'patrol_area_id', 'id');
    }
}
