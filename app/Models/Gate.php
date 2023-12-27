<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'gate';

    public function patrol_area()
    {
        return $this->belongsTo(PatrolArea::class, 'patrol_area_id', 'id');
    }
}
