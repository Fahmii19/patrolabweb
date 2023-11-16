<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomingVehicle extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'outcoming_vehicle';

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'id_project');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
}
