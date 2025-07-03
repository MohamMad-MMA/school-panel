<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Validation\Rule;


use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = \App\Models\Subject::all();
        return view('subjects.index', compact('subjects'));
    }
    public function create()
    {
        $grades = Grade::all();
        return view('subjects.create', compact('grades'));
    }
    public function edit(Subject $subject)
    {
        $grades = Grade::all();
        return view('subjects.edit', compact('subject', 'grades'));
    }
    public function destroy($id)
    {
        $subject = \App\Models\Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'درس با موفقیت حذف شد.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subjects')->where(function ($query) use ($request) {
                    return $query->where('grade_id', $request->grade_id);
                }),
            ],
            'topics_count' => 'required|integer|min:0',
            'grade_id' => 'required|exists:grades,id',
        ], [
            'name.unique' => 'درسی با این نام در این پایه قبلاً ثبت شده است.',
        ]);
        Subject::create($request->all());
        return redirect()->route('subjects.index');
    }
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subjects')->where(function ($query) use ($request, $subject) {
                    return $query->where('grade_id', $request->grade_id)
                                ->where('id', '!=', $subject->id);
                })
            ],
            'topics_count' => 'required|integer|min:0',
            'grade_id' => 'required|exists:grades,id',
        ], [
            'name.unique' => 'درسی با این نام در این پایه قبلاً ثبت شده است.',
        ]);
        $subject->update($request->all());
        return redirect()->route('subjects.index');
    }
}