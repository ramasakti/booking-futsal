<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $title = "Menu";
        $menus = MenuModel::getStructured();

        return view('menu.index', compact('title', 'menus'));
    }

    public function store(Request $request)
    {
        $ids = $request->ids;
        $labels = $request->label;
        $urls = $request->url;
        $icons = $request->icon;
        $parents = $request->parent;

        foreach ($ids as $index => $id) {
            MenuModel::where('id', $id)
                ->update([
                    'label'     => $labels[$id] ?? '',
                    'url'       => $urls[$id] ?? '',
                    'icon'      => $icons[$id] ?? '',
                    'parent_id' => $parents[$id] ?? null,
                    'order'     => $index + 1
                ]);
        }

        return back()->with('success', 'Berhasil update menu!');
    }
}
