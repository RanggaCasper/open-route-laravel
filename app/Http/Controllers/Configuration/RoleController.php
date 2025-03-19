<?php

namespace App\Http\Controllers\Configuration;

use App\Helpers\Formatter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    private $formatter;
    public function __construct()
    {
        $this->formatter = new Formatter();
    }

    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index() 
    {
        return view('configuration.roles.index', [
            'permissions' => $this->formatter->formattedPermission(),
        ]);
    }

    public function get()
    {
        try {
            $data = Role::all();
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
            $data = Role::findOrFail($id);
            $permissions = $this->formatter->formattedPermission();
            $html = view('configuration.roles.ajax.update', [
                'data' => $data,
                'permissions' => $permissions,
            ])->render();
            return ResponseFormatter::success('Data berhasil diambil.', $html);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'permission' => 'nullable|array',
            'permission.*' => 'exists:permissions,name',
        ]);

        try {
            $data = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            $data->givePermissionTo($request->permission);

            return ResponseFormatter::created();   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'permission' => 'nullable|array',
            'permission.*' => 'exists:permissions,name',
        ]);
        
        try {
            $data = Role::findOrFail($id);
            
            $data->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            $data->syncPermissions($request->permission);

            return ResponseFormatter::success('Data berhasil diupdate.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Role::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data berhasil dihapus.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}