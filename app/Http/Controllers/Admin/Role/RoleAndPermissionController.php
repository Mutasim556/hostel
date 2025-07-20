<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:role-permission-index,admin')->only('index');
        $this->middleware('permission:role-permission-create,admin')->only('store');
        $this->middleware('permission:role-permission-update,admin')->only(['edit','update']);
        $this->middleware('permission:role-permission-delete,admin')->only('destroy');
        $this->middleware('permission:specific-permission-create,admin')->only(['getUserPermission','giveUserPermission']);
    }
    public function index() : View
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('group_name');
        $users = Admin::where([['delete',0],['status',1]])->get();
        return view('backend.blade.role.index',compact('roles','permissions','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data)
    {
        $data->validate([
            'role_name' => 'required|max:55|unique:roles,name',
        ]);
        $role = Role::create(['guard_name' => 'admin', 'name' => $data->role_name]);
        $role->syncPermissions($data->permissions);
        // dd($role);
        return response([
            'role'=>$role,
            'permissions' => DB::table('role_has_permissions')->join('permissions','role_has_permissions.permission_id','permissions.id')->where('role_id',$role->id)->select('permissions.name')->get(),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.User created successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['user-update','user-delete']),
            'hasEditPermission' => hasPermission(['user-update']),
            'hasDeletePermission' => hasPermission(['user-delete']),
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) 
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : Response
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy('group_name');
        $rolePermissions = $role->permissions;
        $rolePermissions = $rolePermissions->pluck('name')->toArray();
        // dd($rolePermissions);
        return response([
            'role'=>$role,
            'permissions'=>$permissions,
            'rolePermissions'=>$rolePermissions,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id)
    {
        $data->validate([
            'role_name' => 'required|max:55|unique:roles,name,'.$id,
        ]);

        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $data->role_name]);
        $role->syncPermissions($data->permissions);
        $rolePermissions = $role->permissions;
        $rolePermissions = $rolePermissions->pluck('name')->toArray();
        return response([
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Role-permission updated successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if($role->name==='Super Admin'){
            return response(['status'=>'warning','title'=>__('admin_local.Warning !'),'text'=>__("admin_local.Can't delete this role . Sorry !"),'confirmTextButton'=>__('admin_local.Ok')],422);
        }
        $role->delete();
        return response(['title'=>__('admin_local.Congratulations !'),'text'=>__('admin_local.Role removed successfully') ,'confirmTextButton'=>__('admin_local.Ok')],200);
    }



    //custom methods
    public function getUserPermission(string $id) : Response {
        $user = Admin::findOrFail($id);
        $permissions = Permission::all()->groupBy('group_name');
        $userPermissions = $user->permissions;
        $userPermissions = $user->permissions->pluck('name')->toArray();;
        return response([
            'user'=>$user,
            'permissions'=>$permissions,
            'userPermissions'=>$userPermissions,
        ]);
    }

    public function giveUserPermission(Request $data){
        
        $user = Admin::findOrFail($data->user_id);
        // $user->update(['guard_name' => 'admin', 'name' => $data->role_name]);
        $user->syncPermissions($data->permissions);

        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Permission assiened successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
        
    }
}
