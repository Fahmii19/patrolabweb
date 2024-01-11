<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationConditionOption extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'location_condition_option';
}
