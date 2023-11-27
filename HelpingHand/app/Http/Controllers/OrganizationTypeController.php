<?php

namespace App\Http\Controllers;

use App\Models\OrganizationType;
use App\Models\Specialization;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    //
    public function index()
    {
        $organization_type = OrganizationType::with('specialization')->get();
        // dd($organization_type);
        return view('pages.organizationtype.index', compact('organization_type'));
    }
    public function create()
    {
        return view('pages.organizationtype.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'name' => 'required',
            'specialization' => 'required',
        ]);
        $inputArray = explode(',', $request->specialization);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        foreach ($uniqueTags as $tagName) {
            $tag = Specialization::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $org_type = OrganizationType::firstorCreate([
            'org_type' => $request->name,
        ]);
        $org_type->specialization()->sync($tagIds);

        return redirect()->route('organizationtype');
    }
    public function update(Request $request)
    {

        $credentials = $request->validate([
            'id' => 'required',
            'name' => 'required|unique:organization_types,org_type,'.$request->id,

        ]);
        $inputArray = explode(',', $request->specialization);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        foreach ($uniqueTags as $tagName) {
            $tag = Specialization::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $org_type = OrganizationType::find($request->id);
        $org_type->update([
            'org_type'=>$request->name
        ]);
        $org_type->specialization()->sync($tagIds);

        return redirect()->route('organizationtype');
    }
    public function edit($id)
    {
        $organization_type = OrganizationType::find($id);
        return view('pages.organizationtype.edit', compact('organization_type'));
    }

    public function specialization_suggest(Request $request)
    {
        // dd($request->all());
        $input = $request->input('input');
        $tags = Specialization::where('name', 'like', '%' . $input . '%')->get();
        return response()->json($tags);
    }
    public function delete(Request $request){
        $client = OrganizationType::find($request->id);
        
        if ($client->delete()) {
            return response()->json(['status'=>1, 'Message'=>'client, clients user and images are deleted']);
        } else {
            return response()->json(['status'=>0, 'Message'=>'Unabale to Delete due to unseen Error']);
        }
        
        
    }
}
