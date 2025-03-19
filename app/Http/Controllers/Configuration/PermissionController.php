<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index() 
    {
        $roles = Role::all();
        return view('configuration.permissions.index', [
            'roles' => $roles->pluck('name', 'name')->toArray()
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = Permission::all();
            return DataTables::of($data)  
                ->addColumn('no', function ($row) {  
                    static $counter = 0;  
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {  
                    return '  
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>  
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>
                    ';  
                })  
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = Permission::with('roles')->findOrFail($id);
            return ResponseFormatter::success('Data berhasil diambil.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        try {
            $data = Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            $data->assignRole($request->roles);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        try {
            $data = Permission::findOrFail($id);

            $data->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            $data->syncRoles($request->roles);

            return ResponseFormatter::success('Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = Permission::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data berhasil dihapus.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
