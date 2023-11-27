<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\EmployeeDetail;
use App\Models\Image;
use App\Models\OrganizationType;
use App\Models\Specialization;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Policies\ClientPolicy;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    //
    public function index()
    {
        // dd(Auth::user()->getRoleNames());
   
        $client = EmployeeDetail::with(['images', 'subscription'])->orderby('expires_at', 'desc')->get();
        // dd($client);
        $now = Carbon::now();
        $client = $client->map(function ($item) use ($now) {
            // Calculate the difference between created_at and current date
            $expiresAt = Carbon::parse($item->expires_at);
            $item->expires_at = Carbon::parse($item->expires_at);
            if ($expiresAt > $now) {
                
                $item['remaining_days'] = $expiresAt->diffInDays($now);
            }else{
              
                $item['remaining_days'] = 0;
            }
            
            // $item['expires_at'] = $item->created_at->addDays($item->subscription->subscription_duration*30);

            return $item;
        });
        // dd($client);
        return view('pages.client.index', compact('client'));
    }
    public function create()
    {
        // $this->authorize('create');
        $subscription_list = SubscriptionPackage::where('is_active', 1)->get();
        $organization_type = OrganizationType::where('is_active', 1)->get();
        return view('pages.client.create', compact(['subscription_list', 'organization_type']));
    }
    public function store(request $request)
    {
        // $this->authorize('create');
        // dd($request->all());
        
        $credentials = $request->validate([
            'org_name' => 'required',
            'org_email' => 'required|email|unique:users,email',
            'owner_full_name' => 'required',
            'contact' => 'required',
            'password' => 'required|confirmed',
            'owner_email' => 'required|email',
            'org_type' => 'required',
            'specialization' => 'required',
            'subscription_package' => 'required',
            'image' => 'image'


        ], [
            'org_name.required' => 'Organization Name is Required',
            'org_email.required|email|unique:users' => 'Organization Email is Required',
            'owner_full_name.required' => 'Organization Owner Name is Required',
            'contact.required' => 'Contact is Required',
            'owner_email.required' => 'Organization Owner email is Required',
            'org_type.required' => 'Organization Type is Required',
            'subscription_package.required' => 'Subscription Package is Required',

        ]);
        $subscription = SubscriptionPackage::find($request->subscription_package);
        $expiry_date = Carbon::now()->addDays($subscription->subscription_duration*30);

        $client = EmployeeDetail::create([
            'org_name' => $request->org_name,
            'org_email' => $request->org_email,
            'owner_full_name' => $request->owner_full_name,
            'owner_email' => $request->owner_email,
            'contact' => $request->contact,
            'subscription_package_id' => $request->subscription_package,
            'org_type_id' => $request->org_type,
            'org_description' => $request->org_description,
            'expires_at' => $expiry_date,
        ]);

        $user = User::create([
            'org_name' => $client->org_name,
            'email' => $client->org_email,
            'contact' => $client->contact,
            'org_id' => $client->id,
            'client_admin' => 1,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('ClientAdmin');
        if ($request->hasFile('image')) {
            // $destinationPath = 'assets/admin/uploads/images';

            $slug =  Str::slug($client->org_name) . "-";
            $myimage = $slug . time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'assets/uploads/image/';
            $request->file('image')->move($path, $myimage);
            $image = new Image([
                'name' => $myimage,
                'path' => $path
            ]);
            $client->images()->save($image);
            // $user->images()->save($image);
        }

        // $inputArray = explode(',', $request->specialization);
        // $trimmedArray = array_map('trim', $inputArray);
        // $trimmedArray = array_filter($trimmedArray, function($tagName) {
        //     return !empty($tagName);
        // });
        // $string = implode(', ', $trimmedArray);
        foreach ($request->specialization as $tagName) {
            $tag = Specialization::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $client->specialization()->sync($tagIds);
        return redirect()->route('client')->with('success','Client Created SuccessFully');
    }
    public function update(request $request)
    {
        // dd($request->all());

        $credentials = $request->validate([
            'id' => 'required',
            'org_name' => 'required',
            'org_email' => 'required|email|unique:employee_details,org_email,'. $request->id,
            'owner_full_name' => 'required',
            'contact' => 'required',
            'owner_email' => 'required|email',
            'org_type' => 'required',
            'subscription_package' => 'required',
            'image' => 'image'


        ], [
            'org_name.required' => 'Organization Name is Required',
            'org_email.required|email|unique:users' => 'Organization Email is Required',
            'owner_full_name.required' => 'Organization Owner Name is Required',
            'contact.required' => 'Contact is Required',
            'owner_email.required' => 'Organization Owner email is Required',
            'org_type.required' => 'Organization Type is Required',
            'subscription_package.required' => 'Subscription Package is Required',

        ]);

        $client = EmployeeDetail::find($request->id);
        $user= $client->user()->first();
        // dd($user);
        $user->assignRole('ClientAdmin');
        if ($client->org_email != $request->org_email) {
            $request->validate([
                'org_email' => 'required|email|unique:users,email',
            ]);
        }
       
        if ($client->subscription_package_id !== $request->subscription_package) {
           
            $subscription = SubscriptionPackage::find($request->subscription_package);
            $expiry_date = Carbon::now()->addDays($subscription->subscription_duration*30);
            $client->update([
                'subscription_package_id' => $request->subscription_package,
                'expires_at' => $expiry_date,
            ]);
        }
        $client->update([
            'org_name' => $request->org_name,
            'org_email' => $request->org_email,
            'owner_full_name' => $request->owner_full_name,
            'owner_email' => $request->owner_email,
            'contact' => $request->contact,
            'org_type_id' => $request->org_type,
            'org_description' => $request->org_description,
            
        ]);
        $user = $client->user[0];
        $user->update([
            'org_name' => $client->org_name,
            'email' => $client->org_email,
            'contact' => $client->contact,
        ]);

        if ($request->hasFile('image')) {
            // $destinationPath = 'assets/admin/uploads/images';

            if (count($client->images) > 0) {
                $imagePath = $client->images[0]->path . $client->images[0]->name;
                // Check if the file exists before attempting to delete it
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $client->images[0]->delete();
            }
            $slug =  Str::slug($client->org_name) . "-";
            $myimage = $slug . time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'assets/uploads/image/';
            $request->file('image')->move($path, $myimage);
            $image = new Image([
                'name' => $myimage,
                'path' => $path
            ]);
            $client->images()->save($image);
            // $user->images()->save($image);
        } elseif (isset($request->image_delete)) {
            if (count($client->images) > 0) {
                $imagePath = $client->images[0]->path . $client->images[0]->name;
                // Check if the file exists before attempting to delete it
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $client->images[0]->delete();
            }
            $client->images[0]->delete();
        }
        // $inputArray = explode(',', $request->specialization);
        // $trimmedArray = array_map('trim', $inputArray);
        // $trimmedArray = array_filter($trimmedArray, function($tagName) {
        //     return !empty($tagName);
        // });
        // $string = implode(', ', $trimmedArray);
        foreach ($request->specialization as $tagName) {
            $tag = Specialization::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $client->specialization()->sync($tagIds);
        return redirect()->route('client')->with('success','Client Updated SuccessFully');

    }
    public function edit($id)
    {
        $id1 = base64_decode($id);
        $client = EmployeeDetail::with('images')->find($id1);
        // dd($client);
        $subscription_list = SubscriptionPackage::where('is_active', 1)->get();
        $organization_type = OrganizationType::where('is_active', 1)->get();
        $specialization_list = $client->org_type->specialization->pluck('name')->toArray();
        $specialization_selected = $client->specialization->pluck('name')->toArray();
        // dd($specialization_list,$client->org_type);
        return view('pages.client.edit', compact(['client', 'subscription_list', 'organization_type','specialization_list','specialization_selected']));
    }

    public function delete(Request $request){
        $client = EmployeeDetail::find($request->id);
        if (count($client->images) > 0) {
            $imagePath = $client->images[0]->path . $client->images[0]->name;
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if ($client->delete()) {
            return response()->json(['status'=>1, 'Message'=>'client, clients user and images are deleted']);
        } else {
            return response()->json(['status'=>0, 'Message'=>'Unabale to Delete due to unseen Error']);
        }
        
        
    }
    public function renew(Request $request){
        $client = EmployeeDetail::find($request->id);
        $subscription = $client->subscription;
        $now = Carbon::now();
        $expires_at =  Carbon::parse($client->expires_at);
        $expires_at1 =  Carbon::parse($client->expires_at);
        if ($now > $client->expires_at) {
            $expiry_date = Carbon::now()->addDays($subscription->subscription_duration*30);
        } else {
            $expiry_date = $expires_at->addDays($subscription->subscription_duration*30);
        }
        $client->update([
            'expires_at'=>$expiry_date
        ]);
        return response()->json(['status'=>1, 'Message'=>'Client Package Renewd SuccessFully']);
        // dump($expires_at1->format('Y-m-d H:i:s'));
        // dump($subscription->subscription_duration*30);
        // dump($expiry_date->format('Y-m-d H:i:s'));
        // dump("previous->".$expiry_date->diffInDays($expires_at1));
        // dd("now->".$expiry_date->diffInDays($now));
        
        
    }

    public function get_organizationtype_specialization(Request $request){
        // dd($request->all());
        $request->validate([
            'id'=>'required',
        ]);
        $org_type = OrganizationType::find($request->id);
        $specialization_list = $org_type->specialization;
        return response()->json($specialization_list);
    }
 
}
