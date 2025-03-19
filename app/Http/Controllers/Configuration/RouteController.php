<?php

namespace App\Http\Controllers\Configuration;

use App\Models\Route;
use App\Rules\RouteExists;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route as Routes;
use Illuminate\Routing\Controllers\HasMiddleware;

class RouteController extends Controller implements HasMiddleware
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
        $routes = Routes::getRoutes();
        $existingRoutes = Route::all()->pluck('route')->toArray();
        $routesArray = collect($routes)  
            ->filter(function ($route) use ($existingRoutes) {  
                return $route->getName() && !in_array($route->getName(), $existingRoutes);  
            })  
            ->mapWithKeys(function ($route) {  
                return [$route->getName() => $route->getName()];  
            });
        $routesArrayUpdate = collect($routes)->filter(function ($route) {  
                return $route->getName();
            })->mapWithKeys(function ($route) {  
                return [$route->getName() => $route->getName()];
            });
        return view('configuration.routes.index', [
            'permissions' => $permissions->pluck('name', 'name')->toArray(),
            'routes' => $routesArray,
            'routes_update' => $routesArrayUpdate
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = Route::all();
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
                ->addColumn('action', function ($row) {  
                    return '  
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>  
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>
                    ';  
                })  
                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = Route::findOrFail($id);
            return ResponseFormatter::success('Data berhasil diambil.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'route' => [
                'required',
                new RouteExists()
            ],
            'permission' => 'required|string|max:255',
        ]);

        try {
            Route::create([
                'route' => $request->route,
                'permission_name' => $request->permission,
                'status' => $request->status ? true : false,
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'route' => [
                'required',
                new RouteExists()
            ],
            'permission' => 'required|string|max:255',
        ]);

        try {
            $data = Route::findOrFail($id);

            $data->update([
                'route' => $request->route,
                'permission_name' => $request->permission,
                'status' => $request->status ? true : false,
            ]);

            return ResponseFormatter::success('Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = Route::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data berhasil dihapus.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
