<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LapanganModel extends Model
{
    protected $table = 'lapangan', $guarded = [];

    public function foto()
    {
        return $this->hasMany(FotoLapanganModel::class, 'lapangan_id', 'id');
    }
}
