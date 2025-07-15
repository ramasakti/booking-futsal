<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = 'menu', $guarded = [];

    // Relasi ke anak-anak (child menu)
    public function children()
    {
        return $this->hasMany(MenuModel::class, 'parent_id', 'id')->with('children')->orderBy('order');
    }

    // Relasi ke induk (parent menu)
    public function parent()
    {
        return $this->belongsTo(MenuModel::class, 'parent_id');
    }

    // Scope untuk ambil navbar yang terstruktur
    public static function getStructured()
    {
        return self::whereNull('parent_id')->with('children')->orderBy('order')->get();
    }

    // Single role
    public static function getStructuredByRole($roleId)
    {
        return self::whereNull('parent_id')
            ->where('active', true)
            ->whereIn('id', function ($query) use ($roleId) {
                $query->select('menu_id')->from('access_role')->where('role_id', $roleId);
            })
            ->with(['children' => function ($q) use ($roleId) {
                $q->whereIn('id', function ($query) use ($roleId) {
                    $query->select('menu_id')->from('access_role')->where('role_id', $roleId);
                });
            }])
            ->orderBy('order')
            ->get();
    }

    // Multi role
    public static function getStructuredByRoles($roleIds)
    {
        return self::whereNull('parent_id')
            ->where('active', true)
            ->whereIn('id', function ($query) use ($roleIds) {
                $query->select('menu_id')
                    ->from('access_role')
                    ->whereIn('role_id', $roleIds);
            })
            ->with(['children' => function ($q) use ($roleIds) {
                $q->whereIn('id', function ($query) use ($roleIds) {
                    $query->select('menu_id')
                        ->from('access_role')
                        ->whereIn('role_id', $roleIds);
                });
            }])
            ->orderBy('order')
            ->get();
    }

    // Relasi many‑to‑many ke roles
    public function roles()
    {
        return $this->belongsToMany(
            RoleModel::class,   // model tujuan
            'access_role',      // nama pivot
            'menu_id',          // FK di pivot ke menu
            'role_id'           // FK di pivot ke role
        );
    }

    // Mendapatkan url route berdasarkan role
    public static function getRouteNamesByRoles($roleIds)
    {
        return static::query()
            ->whereHas('roles', fn($q) => $q->whereIn('role.id', $roleIds))
            ->pluck('url')
            ->unique()
            ->values();
    }
}
