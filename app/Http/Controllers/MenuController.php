<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $title = "Menu";
        $menus = MenuModel::getStructured();

        return view('menu.index', compact('title', 'menus'));
    }

    public function update(Request $request)
    {
        $ids     = $request->ids;
        $labels  = $request->label;
        $urls    = $request->url;
        $icons   = $request->icon;
        $parents = $request->parent;
        $actives = $request->active;

        try {
            DB::beginTransaction();

            // Hapus menu yang tidak ada (hanya id positif yang valid)
            MenuModel::whereIn('id', MenuModel::pluck('id'))
                ->whereNotIn('id', array_filter($ids, fn($id) => is_numeric($id) && $id > 0))
                ->delete();

            foreach ($ids as $index => $id) {
                $data = [
                    'label'     => $labels[$id] ?? '',
                    'url'       => $urls[$id] ?? '',
                    'icon'      => $icons[$id] ?? '',
                    'parent_id' => $parents[$id] > 0 ? $parents[$id] : null,
                    'order'     => $index + 1,
                    'active'    => isset($actives[$id]) ? 1 : 0
                ];

                if (is_numeric($id) && $id > 0) {
                    MenuModel::where('id', $id)->update($data);
                } else {
                    MenuModel::create($data); // baru, akan pakai autoincrement
                }
            }

            DB::commit();
            return back()->with('success', 'Berhasil update menu!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal update menu: ' . $th->getMessage());
            return back()->with('error', 'Gagal menyimpan menu!');
        }
    }
}
