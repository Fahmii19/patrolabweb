<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolAccidentalLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'patrol_accidental_log';

    public function location_condition()
    {
        return $this->belongsTo(LocationConditionOption::class, 'location_condition_option_id', 'id');
    }

    public function data_guard()
    {
        return $this->belongsTo(Guard::class, 'guard_id', 'id');
    }

    public function pleton()
    {
        return $this->belongsTo(Pleton::class, 'pleton_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

}
