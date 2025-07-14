<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleModel extends Model
{
    protected $table = 'user_role', $guarded = [];

    public function role()
    {
        return $this->hasOne(RoleModel::class, 'id', 'role_id');
    }
}
