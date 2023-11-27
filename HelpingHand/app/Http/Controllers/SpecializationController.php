<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    //
    public function index()
    {
        $specialization = Specialization::all();
        // dd($specialization);
        return view('pages.specialization.index', compact('specialization'));
    }
    public function create()
    {
        return view('pages.specialization.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'name' => 'required|unique:specialization,name',
        ],[
            'name.unique'=>'This specialization is already in database'
        ]);
        
            $tag = Specialization::firstOrCreate(['name' => $request->name]);

        return redirect()->route('specialization');
    }
    public function update(Request $request)
    {

        $credentials = $request->validate([
            'id' => 'required',
            'name' => 'required|unique:specialization,name,'. $request->id,
        ],[
            'name.unique'=>'This specialization is already in database'
        ]);

        $specialization = specialization::find($request->id);
        $specialization->update([
            'name'=>$request->name,
        ]);
       

        return redirect()->route('specialization');
    }
    public function edit($id)
    {
        $specialization = specialization::find($id);
        return view('pages.specialization.edit', compact('specialization'));
    }

    public function specialization_suggest(Request $request)
    {
        // dd($request->all());
        $input = $request->input('input');
        $tags = Specialization::where('name', 'like', '%' . $input . '%')->get();
        return response()->json($tags);
    }

    public function delete(Request $request){
        $client = Specialization::find($request->id);
        
        if ($client->delete()) {
            return response()->json(['status'=>1, 'Message'=>'Specialization deleted successfully']);
        } else {
            return response()->json(['status'=>0, 'Message'=>'Unabale to Delete due to unseen Error']);
        }
        
        
    }
}
