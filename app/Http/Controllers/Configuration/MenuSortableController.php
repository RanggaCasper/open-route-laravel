<?php

namespace App\Http\Controllers\Configuration;

use App\Helpers\ResponseFormatter;
use App\Models\MenuItem;
use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuSortableController extends Controller
{
    public function index()
    {
        $menus = MenuGroup::with('items')->orderBy('position')->get();
        return view('configuration.menu-sortable.index', [
            'menus' => $menus
        ]);
    }

    public function update(Request $request, $type)  
    {  
        $data = $request->data;  

        if ($type == 'item') {
            foreach ($data as $item) {  
                if (isset($item['id'])) {  
                    MenuItem::where('id', $item['id'])->update(['position' => $item['position']]);  
                }  
            }  
        }

        if($type == 'group') {
            foreach ($data as $item) {  
                MenuGroup::where('id', $item['id'])->update(['position' => $item['position']]);  
            }  
        }
        
        return ResponseFormatter::success('Data berhasil diperbarui.');  
    }

    public function getById(Request $request, $id)
    {
        try {
            $menus = MenuGroup::with(['items' => function($query) {  
                $query->orderBy('position');
            }])->findOrFail($id);
            $html = view('configuration.menu-sortable.ajax.items', [
                'menus' => $menus
            ])->render();
            return ResponseFormatter::success('Data berhasil diambil.', $html);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
