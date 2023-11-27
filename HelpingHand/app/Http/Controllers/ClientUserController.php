<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class ClientUserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index(){
        $user = $this->user;
        $client= $user->client;
        $user_list=$client->user()->where('client_admin',0)->get();
        return view('pages.client_user.index',compact('user_list'));
        
    }
    public function create(){
        return view('pages.client_user.create');
    }
    public function store(Request $request){
        dd($request->all());
        $user = $this->user;
       $request->validate([
            // 'org_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'password' => 'required|confirmed',
            'stage'=>'required'
       ]);
        $new_user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'org_id' => $request->id,
            'password' => Hash::make($request->password),
            'org_name' => $user->org_name,
            'org_id' => $user->org_id,
            'client_admin'=>0,
        ]);
        $new_user->assignRole('StageUser');
        if (isset($request->HR)) {
            $new_user->assignRole('HR');
        }
        foreach ($request->stage as $key => $value) {
            $Permission1 = Permission::findByName('Edit-Stage'.$value);
            $new_user->givePermissionTo($Permission1);
        }
        return redirect()->route('sub_user')->with('success', 'User Updated SuccessFully');
    }
    public function edit($id){
        $id= base64_decode($id);
        $user= User::findOrFail($id);
        return view('pages.client_user.edit',compact('user'));
    }
    public function update(Request $request){
        $allowed = [1,2,3,4,5];
        $validator = Validator::make([$request],[
            'stage.*'=>[
                'required',
                Rule::in($allowed),
            ],
        ]);
        $id = base64_decode($request->id);
        $user = User::findOrFail($id);
        $request->validate([
            // 'org_name' => 'required',
            'email' => 'required|email|unique:users,email,'. $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',  
            'stage.*'=>[
                'required',
                Rule::in($allowed),
            ],         

        ]);
        
       
      
       
        if (isset($request->password)) {
            $request->validate([
                'password' => 'confirmed',    
            ]);
            $user->update([
                'password' => Hash::make($request->password),             
            ]);
        }
        
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,         
        ]);
        $user->assignRole('StageUser');
        if (isset($request->HR)) {
            $user->assignRole('HR');
        }elseif($user->hasRole('HR')){
            $user->removeRole('HR');
        }
       $current_permission=  $user->permissions->pluck('name');
       foreach ($current_permission as $key => $value) {
        $user->revokePermissionTo($value);
       }
    //    $user->revokePermissionTo([$current_permission]);
        foreach ($request->stage as $key => $value) {
            $Permission1 = Permission::findByName('Edit-Stage'.$value);
            $user->givePermissionTo($Permission1);
        }
        return redirect()->route('sub_user')->with('success', 'User Updated SuccessFully');
    }
    public function delete(){
        
    }
}
