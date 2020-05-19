<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\Role\StoreRole;
use App\Http\Requests\Role\StoreUserRole;
use App\Http\Requests\Role\UpdateRole;
use App\Module;
use App\Permission;
use App\PermissionRole;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DB;

class ManageRolePermissionController extends Controller
{
    public function __construct() {
    }

    public function index(){
        $roles = Role::with('permissions')->where('id', '>', 3)->get();

        $totalPermissions = Permission::count();
        $modulesData = Module::with('permissions')->where('module_name', '<>', 'contracts')->get();
         

        $data = compact('roles', 'totalPermissions', 'modulesData');
        // dd($data);
      
        return Reply::successWithData('Permisos', $data);
        // return view('admin.role-permission.index', $this->data);
    }

    public function view(){
        $data = Permission::all();

        $vista = compact('data');
       //$vista = \DB::table('permissions')->select('id','name','display_name','module_id')->get();
       return ($vista);
    }

    public function store(Request $request){
        $roleId = $request->roleId;
        $permissionId = $request->permissionId;

        if($request->assignPermission == 'true'){
            $rolePermission = new PermissionRole();
            $rolePermission->permission_id = $permissionId;
            $rolePermission->role_id = $roleId;
            $rolePermission->save();
        }
        else{
            PermissionRole::where('role_id', $roleId)->where('permission_id', $permissionId)->delete();
        }

        return Reply::dataOnly(['status' => 'success']);
    }
    public function assignAllPermission(Request $request){
        $roleId = $request->roleId;
        $permissions = Permission::all();

        $role = Role::findOrFail($roleId);
        $role->perms()->sync([]);
        $role->attachPermissions($permissions);
        return Reply::dataOnly(['status' => 'success']);
    }

    public function removeAllPermission(Request $request){
        $roleId = $request->roleId; 

        $role = Role::findOrFail($roleId);
        $role->perms()->sync([]);

        return Reply::dataOnly(['status' => 'success']);
    }

    public function storeRole(StoreRole $request){
        $roleUser = new Role();
        $roleUser->name = $request->name;
        $roleUser->display_name = ucwords($request->name);
        $roleUser->save();
        return Reply::success('Rol creado');
    }

    public function assignRole(StoreUserRole $request){
        $employeeRole = Role::where('name', 'employee')->first();
        foreach($request->user_id as $user){
            RoleUser::where('user_id', $user)->delete();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user;
            $roleUser->role_id = $employeeRole->id;
            $roleUser->save();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user;
            $roleUser->role_id = $request->role_id;
            $roleUser->save();
        }
        return Reply::success('Rol asignado');
    }

    public function detachRole(Request $request){
        $user = User::withoutGlobalScopes(['active'])->findOrFail($request->userId);
        $user->detachRole($request->roleId);
        return Reply::dataOnly(['status' => 'success']);
    }

    public function deleteRole(Request $request){
        Role::whereId($request->roleId)->delete();
        return Reply::dataOnly(['status' => 'success']);
    }

    public function update2(UpdateRole $request, $id){
        $roleUser = Role::findOrFail($id);
        $roleUser->name = $request->value;
        $roleUser->display_name = ucwords($request->value);
        $roleUser->save();

        return Reply::successWithData('Rol actualizado', ['display_name' => $roleUser->display_name]);
    }

    ////METODOS CRUD ROLES/////

     //----CREACION NUEVO ROL-----////
     public function storeCreate(Request $request){
        $roles = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);
        $data = Role::where('id')->get();
        $status = 'success';
            return response()->json(compact('data', 'status'));
     }
     //------DELETE ROOL-------////
     public function destroy($id){
        $roles = Role::find($id);
         $roles->delete();
         $data = Role::where('id')->get();
         $status = 'success';
             return response()->json(compact('data','status'));
    }
    //Editar Rol 
    public function update(Request $request, $id){
        $roles = Role::findOrFail($id);
        $roles->update($request->all());
            $data = Role::all();
            $status = 'success';
        
               return response()->json(compact('data', 'status'));
    }

    //Funcion  Extra
     //elimina Todos lo Roles de un jalon
     public function deleteRol(Request $request){
        Role::where($request->id)->delete();
        return Reply::dataOnly(['status' => 'success']);
    }
    
}
