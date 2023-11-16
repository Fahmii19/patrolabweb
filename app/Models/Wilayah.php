<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = 'wilayahs';
    protected $table = 'city';

    public function areas(){
        return $this->hasMany(Area::class,'id_wilayah');
    }

    public function projects()
    {
        return $this->hasMany(ProjectModel::class, 'wilayah');
    }

    public function data_guards(){
        return $this->hasMany(Guard::class,'id_wilayah');
    }
    public function checkpoints()
    {
        return $this->hasMany(CheckPoint::class, 'id_wilayah');
    }
    public function selfpatrols()
    {
        return $this->hasMany(SelfPatrol::class, 'id_wilayah');
    }

    public function atensis()
    {
        return $this->hasMany(Atensi::class, 'id_wilayah');
    }

    public function incomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_wilayah');
    }

    public function outcomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_wilayah');
    }
}

