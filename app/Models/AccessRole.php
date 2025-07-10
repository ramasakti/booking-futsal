<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRole extends Model
{
    protected $table = 'access_role', $guarded = [];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(MenuModel::class, 'menu_id');
    }

    // Static method untuk ambil semua menu dari role tertentu
    public static function getMenusByRole($roleId)
    {
        // Ambil semua menu yang diakses role, beserta struktur child-nya
        return MenuModel::whereIn('id', function ($query) use ($roleId) {
            $query->select('menu_id')
                ->from('access_role')
                ->where('role_id', $roleId);
        })
            ->with(['children' => function ($q) use ($roleId) {
                $q->whereIn('id', function ($query) use ($roleId) {
                    $query->select('menu_id')
                        ->from('access_role')
                        ->where('role_id', $roleId);
                })->with('children')->orderBy('order');
            }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
    }
}
