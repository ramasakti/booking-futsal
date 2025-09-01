<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    protected $table = 'kelas', $guarded = [];

    public function walas()
    {
        return $this->hasOne(User::class, 'id', 'walas_id');
    }

    public function mitra()
    {
        return $this->hasOne(User::class, 'id', 'mitra_id');
    }

    public function institusi()
    {
        return $this->hasOne(InstitusiModel::class, 'id', 'institusi_id');
    }
}
