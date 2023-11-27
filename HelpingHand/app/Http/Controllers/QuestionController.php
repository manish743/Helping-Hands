<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Skill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function index()
    {
        $question_list = Question::where('created_by', 1)->get();
        $client_question = Question::where('created_by', '!=', 1)->with('client')->get();
        return view('pages.Questions.index', compact('question_list', 'client_question'));
    }
    public function create()
    {
        $skill = Skill::all()->pluck('name');
        return view('pages.Questions.create', compact('skill'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'question' => 'required|unique:questions,question',
            'skills' => 'required',
        ]);

        $inputArray = explode(',', $request->skills);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        // dd($uniqueTags);
        foreach ($uniqueTags as $tagName) {
            $skill = Skill::where('name', $tagName)->first();
            // dd($skill);
            if ($skill) {
                $skillIds[] = $skill->id;
            }
        }
        // dd($skillIds);
        $question = Question::Create([
            'question' => $request->question,
            'created_by' => Auth::id()
        ]);
        $question->skills()->sync($skillIds);
        return redirect()->route('question')->with('success', 'Question Add Successfully');
    }
    public function edit($id)
    {
        $question = Question::where('id', $id)->with('skills')->first();
        $skill_list = $skill = Skill::all()->pluck('name')->toArray();
        $skill_selected = $question->skills->pluck('name')->toArray();
        // dd($question);
        return view('pages.Questions.edit', compact('question', 'skill_list', 'skill_selected'));
    }

    public function update(Request $request)
    {

        // dd($request->all());
        $customMessages = [
            'question.required' => 'The question field is required.',
            'question.unique' => 'The question already existed.',

        ];
        $rules = [
            'id' => 'required',
            'question' => 'required|unique:questions,question,' . $request->id,
            'skills' => [
                'required',
                function ($attribute, $value, $fail) {
                    $userIds = (array) $value;
                    $inputArray = explode(',', $value);
                    $trimmedArray = array_map('trim', $inputArray);
                    $uniqueTags = [];
                    foreach ($trimmedArray as $tagName) {
                        if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                            $uniqueTags[] = $tagName;
                        }
                    }

                    $exists = DB::table('skills')
                        ->whereIn('name', $uniqueTags)
                        ->count();

                    if (count($uniqueTags) !== $exists) {
                        $fail("One or more selected skills do not exist.");
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            // dd('failedd');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inputArray = explode(',', $request->skills);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        // dd($uniqueTags);
        foreach ($uniqueTags as $tagName) {
            $skill = Skill::where('name', $tagName)->first();
            // dd($skill);
            if ($skill) {
                $skillIds[] = $skill->id;
            }
        }

        $question = Question::find($request->id);
        $question->update([
            'question' => $request->question
        ]);
        $question->skills()->sync($skillIds);
        return redirect()->route('question')->with('success', 'Question Updated Successfully');
    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $question = Question::find($request->id);


        if ($question->delete()) {
            return response()->json(['status' => 1, 'message' => 'Question Deleted Successfully']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Unable to Deleted Question Due to Unseen Errors']);
        }
    }
}
