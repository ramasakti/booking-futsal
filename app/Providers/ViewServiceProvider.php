<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuModel;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.dashboard', function ($view) {
            $user = Auth::user();
            $menus = [];

            if ($user && $user->userRole) {
                $roleId = $user->userRole->role_id;
                $menus = MenuModel::getStructuredByRole($roleId);
            }

            $view->with('menus', $menus);
        });
    }
}
