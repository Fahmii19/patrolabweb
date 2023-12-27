<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PletonPatrolArea extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pleton_patrol_area';

    public function pleton()
    {
        return $this->belongsTo(Pleton::class, 'pleton_id', 'id');
    }

    public function patrol_area()
    {
        return $this->belongsTo(PatrolArea::class, 'patrol_area_id', 'id');
    }
}
