<?php

namespace App\Http\Controllers\Configuration;

use App\Models\MenuItem;
use App\Models\MenuGroup;
use App\Rules\RouteExists;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;

class MenuItemController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }
    public function index()
    {
        $permissions = Permission::all();
        $groups = MenuGroup::all();
        $routes = Route::getRoutes();
        $routesArray = collect($routes)->filter(function ($route) {  
            return $route->getName();
        })->mapWithKeys(function ($route) {  
            return [$route->getName() => $route->getName()];
        }); 
        return view('configuration.menu-items.index',[
           'permissions' => $permissions->pluck('name', 'name')->toArray(),
           'groups' => $groups->pluck('name', 'id')->toArray(),
           'routes' => $routesArray,
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = MenuItem::with('group')->orderBy('position')->get();
            return DataTables::of($data)  
                ->addColumn('no', function ($row) {  
                    static $counter = 0;  
                    return ++$counter;
                })
                ->addColumn('status', function ($row){
                    return $row->status   
                            ? '<span class="badge bg-success">Active</span>'   
                            : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('icon_preview', function ($row){
                    return '<i class="' . $row->icon . '"></i>';
                })
                ->addColumn('action', function ($row) {  
                    return '
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>  
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>
                    ';  
                })
                ->rawColumns(['action','icon_preview','status'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = MenuItem::with('group')->findOrFail($id);
            return ResponseFormatter::success('Data berhasil diambil.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'route' => [
                'required',
                new RouteExists()
            ],
            'icon' => 'required|string|max:255',
            'permission' => 'required|exists:permissions,name',
            'menu_group_id' => 'required|exists:menu_groups,id',
        ]);

        try {
            MenuItem::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'route' => $request->route,
                'permission_name' => $request->permission,
                'position' => MenuItem::max('position') + 1,
                'status' => $request->status ? true : false,
                'menu_group_id' => $request->menu_group_id
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'route' => [
                'required',
                new RouteExists()
            ],
            'icon' => 'required|string|max:255',
            'permission' => 'required|exists:permissions,name',
            'menu_group_id' => 'required|exists:menu_groups,id',
        ]);
            
        try {
            $data = MenuItem::findOrFail($id);

            $data->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'route' => $request->route,
                'permission_name' => $request->permission,
                'status' => $request->status ? true : false,
                'menu_group_id' => $request->menu_group_id
            ]);

            return ResponseFormatter::success('Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        } 
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = MenuItem::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data berhasil dihapus.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
