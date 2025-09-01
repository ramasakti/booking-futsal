<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInstitusiModel extends Model
{
    protected $table = 'user_institusi', $guarded = [];

    public function institusi()
    {
        return $this->hasOne(InstitusiModel::class, 'id', 'institusi_id');
    }
}
