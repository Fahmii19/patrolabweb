<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'notice_board';

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
