<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalasModel extends Model
{
    protected $table = 'user_walas', $guarded = [];

    public function kelas()
    {
        $this->hasOne(KelasModel::class, 'kelas_id');
    }

    public function walas()
    {
        $this->hasOne(User::class, 'user_id');
    }
}
