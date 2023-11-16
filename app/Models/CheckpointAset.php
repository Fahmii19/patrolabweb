<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointAset extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'checkpoint_aset';

    public function cpa()
    {
        return $this->belongsTo(Checkpoint::class, 'id_check_point');
    }
}
