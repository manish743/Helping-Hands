<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscription_list = SubscriptionPackage::where('is_active', 1)->get();
        return view('pages.subscription.index', compact('subscription_list'));
    }
    public function create()
    {
        return view('pages.subscription.create');
    }
    public function store(request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'name' => 'required',
            'package_type' => 'required',
            'subscription_duration' => 'required|numeric',
            'no_of_users' => 'required|numeric',
            'no_of_vacancy' => 'required|numeric',
            'can_generate_link' => 'required',
            'can_ask_cim' => 'required',

        ], [
            'name.required' => 'Subscription Name is Required',
            'package_type.required' => 'package type   is Required',
            'subscription_duration.required' => 'subscription duration   is Required',
            'subscription_duration.numeric' => 'subscription duration   is Required',
            'no_of_users.required' => 'no of users   is Required',
            'no_of_users.numeric' => 'no of users   is Required',
            'no_of_vacancy.required' => 'no of vacancy   is Required',
            'no_of_vacancy.numeric' => 'no of vacancy   is Required',
            'can_generate_link.required' => 'can generate link   is Required',
            'can_ask_cim.required' => 'can ask cim   is Required',
        ]);

        $subscription = SubscriptionPackage::create([
            'name' => $request->name,
            'package_type' => $request->package_type,
            'subscription_duration' => $request->subscription_duration,
            'no_of_users' => $request->no_of_users,
            'no_of_vacancy' => $request->no_of_vacancy,
            'can_generate_link' => $request->can_generate_link,
            'can_ask_cim' => $request->can_ask_cim,
        ]);
        return redirect()->route('subscription')->with('success', 'Subscription Package Created Successfully');
    }
    public function update(request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'package_type' => 'required',
            'subscription_duration' => 'required|numeric',
            'no_of_users' => 'required|numeric',
            'no_of_vacancy' => 'required|numeric',
            'can_generate_link' => 'required',
            'can_ask_cim' => 'required',
            'is_active' => 'required',

        ], [
            'name.required' => 'Subscription Name is Required',
            'package_type.required' => 'package type   is Required',
            'subscription_duration.required' => 'subscription duration   is Required',
            'subscription_duration.numeric' => 'subscription duration   is Required',
            'no_of_users.required' => 'no of users   is Required',
            'no_of_users.numeric' => 'no of users   is Required',
            'no_of_vacancy.required' => 'no of vacancy   is Required',
            'no_of_vacancy.numeric' => 'no of vacancy   is Required',
            'can_generate_link.required' => 'can generate link   is Required',
            'can_ask_cim.required' => 'can ask cim   is Required',
        ]);

        $subscription = SubscriptionPackage::find($request->id);
        
       $subscription-> update([
            'name' => $request->name,
            'package_type' => $request->package_type,
            'subscription_duration' => $request->subscription_duration,
            'no_of_users' => $request->no_of_users,
            'no_of_vacancy' => $request->no_of_vacancy,
            'can_generate_link' => $request->can_generate_link,
            'can_ask_cim' => $request->can_ask_cim,
            'is_active' => $request->is_active,
        ]);
        return redirect()->route('subscription')->with('success', 'Subscription Package Updated Successfully');
    }
    public function edit($id)
    {
        $subscription = SubscriptionPackage::find($id);
        return view('pages.subscription.edit', compact('subscription'));
    }

    public function get_subscription(Request $request){
        // dd($request->all());
        $subscription = SubscriptionPackage::find($request->id);
        $list = SubscriptionPackage::where('id','!=', $request->id)->get();
        return response()->json(['status'=>1,'list'=>$list,'old_id'=>$request->id]);
    }
    public function delete(Request $request){
        // dd($request->all());
        $subscription = SubscriptionPackage::find($request->id);
        // $subscription->deleteWithReassign($request->new_subscription_id);
        // $subscription->delete();
        // return redirect()->route('subscription')->with('success', 'Subscription Package Deleted Successfully');

        if ($subscription->client()->count()==0) {
            // dd('ok'.$subscription->client()->count());
            $subscription->delete();
            return response()->json(['status' => 1, 'message' => 'Skill Deleted Succcessfully']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Unabale to Delete Clients are using this subscription']);
        }

    }
}
