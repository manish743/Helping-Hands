<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index()
    {
        $user = $this->user;
        $user_list = User::where('sub_user', 1)->get();
        return view('pages.admin_user.index', compact('user_list'));
    }
    public function create()
    {
        return view('pages.admin_user.create');
    }
    public function store(Request $request)
    {
        $user = $this->user;
        $request->validate([
            // 'org_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'password' => 'required|confirmed',

        ]);
        $new_user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'sub_user' => 1,
        ]);
        $new_user->assignRole('HIMSubUser');

        return redirect()->route('admin_user')->with('success', 'Sub User Created SuccessFully');
    }
    public function edit($id)
    {
        $id= base64_decode($id);
        $user= User::findOrFail($id);
        return view('pages.admin_user.edit',compact('user'));
    }
    public function update(Request $request)
    {
        $id = base64_decode($request->id);
        $user = User::findOrFail($id);
        $request->validate([
            // 'org_name' => 'required',
            'email' => 'required|email|unique:users,email,'. $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',           

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
        $user->assignRole('HIMSubUser');
        return redirect()->route('admin_user')->with('success', 'Sub User Updated SuccessFully');
    }
    public function delete(Request $request)
    {
        $id = base64_decode($request->id);
        $user1 = User::findOrFail($id);
        if ($user1->delete()) {
            return response()->json(['status' => 1, 'Message' => 'Sub User deleted']);
        } else {
            return response()->json(['status' => 0, 'Message' => 'Unabale to Delete due to unseen Error']);
        }
    }
}
