<?php

namespace App\Http\Controllers\Configuration;

use App\Models\MenuGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Permission;

class MenuGroupController extends Controller implements HasMiddleware
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
        return view('configuration.menu-group.index',[
           'permissions' => $permissions->pluck('name', 'name')->toArray()
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = MenuGroup::orderBy('position')->get();
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
                ->rawColumns(['action','status'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = MenuGroup::findOrFail($id);
            return ResponseFormatter::success('Data berhasil diambil.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission' => 'required|exists:permissions,name',
        ]);

        try {
            MenuGroup::create([
                'name' => $request->name,
                'permission_name' => $request->permission,
                'position' => MenuGroup::max('position') + 1,
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
            'name' => 'required|string|max:255',
            'permission' => 'required|exists:permissions,name',
        ]);
            
        try {
            $data = MenuGroup::findOrFail($id);

            $data->update([
                'name' => $request->name,
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
            $data = MenuGroup::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data berhasil dihapus.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
