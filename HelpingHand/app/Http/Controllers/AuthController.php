<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function post_login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $user->last_used_at = Carbon::now();
           $user1 = User::find($user->id);
           $user1->timestamps = false;
           $user1->last_used_at = Carbon::now();
           $user1->save();
            // dump();
            $roles = $user->getRoleNames();
            // dd($user,$roles);

            return redirect()->intended('/')
                ->withSuccess('Signed in');
        }

        return redirect("login")->with('warning', 'Login details are not valid');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function RoleCreate()
    {
        // $role1 = Role::create(['name' => 'StageUser']);
        // $Permission1 = Permission::create(['name' => 'Edit-Stage1']);
        // $Permission1 = Permission::create(['name' => 'Edit-Stage2']);
        // $Permission1 = Permission::create(['name' => 'Edit-Stage3']);
        // $Permission1 = Permission::create(['name' => 'Edit-Stage4']);
        // $Permission1 = Permission::create(['name' => 'Edit-Stage5']);
        // $role1 = Role::create(['name' => 'SuperSubAdmin']);
        // $role2 = Role::create(['name' => 'EmployerAdmin']);
        // $role3 = Role::create(['name' => 'Candidate']);
        return redirect('/');
    }
    public function PermissionCreate()
    {
        Artisan::call('cache:forget spatie.permission.cache ');
        Artisan::call('cache:clear');
        // $role1 = Permission::create(['name' => 'Edit-Subscrition']);
        // $Permission1 = Permission::create(['name' => 'Edit-Client']);
        // $Permission1 = Permission::create(['name' => 'Edit-OrganizationType']);
        // $Permission2 = Permission::create(['name' => 'Edit-Jobs']);
        // $Permission2 = Permission::create(['name' => 'Edit-Skills']);
        // $Permission2 = Permission::create(['name' => 'Edit-QuestionByClient']);
        // $Permission3 = Permission::create(['name' => 'Edit-Candidate']);
        // $Permission3 = Permission::create(['name' => 'Edit-Users']);
        // $role1 = Permission::create(['name' => 'Delete-Subscrition']);
        // $Permission1 = Permission::create(['name' => 'Delete-Client']);
        // $Permission1 = Permission::create(['name' => 'Delete-OrganizationType']);
        // $Permission2 = Permission::create(['name' => 'Delete-Jobs']);
        // $Permission2 = Permission::create(['name' => 'Delete-Skills']);
        // $Permission2 = Permission::create(['name' => 'Delete-QuestionByClient']);
        // $Permission3 = Permission::create(['name' => 'Delete-Candidate']);
        // $Permission3 = Permission::create(['name' => 'Delete-Users']);
        $permissions = Permission::all();
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        // Attach all permissions to the Super Admin role
        $superAdminRole->syncPermissions($permissions);
        return $this-> assignEmployeePermission();
    }
    public function assignRole()
    {
        $user = User::find(1);
        
        $role = Role::findByName('SuperAdmin');
        $permission = Permission::all();
        $role->syncPermissions($permission);
        $user->assignRole('SuperAdmin');
        $all_users_with_all_their_roles = User::with('roles')->first();
        dd($all_users_with_all_their_roles);
    }

    public function assignEmployeePermission()
    {
        Artisan::call('cache:forget spatie.permission.cache ');
        Artisan::call('cache:clear');
        $role = Role::findByName('ClientAdmin');
        $Permission1 = Permission::findByName('Edit-Stage1');
        $Permission2 = Permission::findByName('Edit-Stage2');
        $Permission3 = Permission::findByName('Edit-Stage3');
        $Permission4 = Permission::findByName('Edit-Stage4');
        $Permission5 = Permission::findByName('Edit-Stage5');
        $Permission6 = Permission::findByName('Edit-Jobs');
        $Permission7 = Permission::findByName('Delete-Jobs');
        $Permission8 = Permission::findByName('Edit-Users');
        $Permission9 = Permission::findByName('Delete-Users');
        $Permission10 = Permission::findByName('Edit-Question');
        $Permission11 = Permission::findByName('Delete-Question');
        $Permission12 = Permission::findByName('Edit-Candidate');
        dump($Permission4->name);
        dump($Permission5->name);

        $role->givePermissionTo([$Permission1, $Permission2]);
        $role->givePermissionTo([$Permission3, $Permission4]);
        $role->givePermissionTo([$Permission5, $Permission6]);
        $role->givePermissionTo([$Permission7, $Permission8]);
        $role->givePermissionTo([$Permission9, $Permission10]);
        $role->givePermissionTo([$Permission11,$Permission12]);
        // $role->syncPermissions([$Permission1, $Permission2, $Permission3, $Permission6, $Permission7, $Permission8, $Permission9, $Permission10, $Permission11, $Permission4, $Permission5]);
    dd('ok');
    }
    public function assignSubPermission()
    {
        Artisan::call('cache:forget spatie.permission.cache ');
        Artisan::call('cache:clear');
        $role = Role::findByName('HIMSubUser');
       
        $Permission6 = Permission::findByName('Edit-Jobs');
      
        $Permission12 = Permission::findByName('Edit-Candidate');
   
        // $role->givePermissionTo([$Permission6,$Permission12]);
        $role->syncPermissions([$Permission6,$Permission12]);
        // $role->syncPermissions([$Permission1, $Permission2, $Permission3, $Permission6, $Permission7, $Permission8, $Permission9, $Permission10, $Permission11, $Permission4, $Permission5]);
    dd('ok');
    }
    public function assignStagePermission()
    {
        Artisan::call('cache:forget spatie.permission.cache ');
        Artisan::call('cache:clear');
        $role = Role::findByName('StageUser');
       
        $Permission6 = Permission::findByName('View-Jobs');
        $Permission7 = Permission::findByName('View-JobApplicant');
      
        $Permission12 = Permission::findByName('Edit-JobApplicant');
   
        // $role->givePermissionTo([$Permission6,$Permission12]);
        $role->syncPermissions([$Permission6,$Permission12,$Permission7]);
        // $role->syncPermissions([$Permission1, $Permission2, $Permission3, $Permission6, $Permission7, $Permission8, $Permission9, $Permission10, $Permission11, $Permission4, $Permission5]);
    dd('ok');
    }
}
