<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }
    public function create()
    {
        return view('grades.create');
    }
    public function show(string $id)
    {
        
    }
    public function edit(string $id)
    {
        $grade = Grade::findOrFail($id);
        return view('grades.edit', compact('grade'));
    }
    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'پایه با موفقیت حذف شد.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:grades,name',
        ], [
            'name.unique' => 'پایه‌ای با این نام قبلاً ثبت شده است.',
        ]);

        Grade::create($request->all());
        return redirect()->route('grades.index');
    }
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:grades,name,' . $grade->id,
        ], [
            'name.unique' => 'پایه‌ای با این نام قبلاً ثبت شده است.',
        ]);
        $grade->update($request->all());
        return redirect()->route('grades.index');
    }
}
