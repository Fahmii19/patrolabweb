<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pleton extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pleton';

    public function guards()
    {
        return $this->hasMany(Guard::class, 'pleton_id', 'id');
    }
}
