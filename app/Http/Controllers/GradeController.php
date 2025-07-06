<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::withCount([
            'classes',
            'subjects',
            'students',
        ])->get();
        foreach ($grades as $grade) {
            $teacherIds = DB::table('teacher_subject_class')
                ->join('subjects', 'teacher_subject_class.subject_id', '=', 'subjects.id')
                ->where('subjects.grade_id', $grade->id)
                ->distinct()
                ->pluck('teacher_subject_class.teacher_id');
            $grade->teachers_count = $teacherIds->count();
            $studentIds = $grade->students->pluck('id');
            $scores = \App\Models\Score::whereIn('student_id', $studentIds)->get();
            $total = 0;
            $count = 0;
            foreach ($scores as $score) {
                $subject = $score->subject;
                if ($subject && $subject->coefficient) {
                    $total += $score->score * $subject->coefficient;
                    $count += $subject->coefficient;
                } else {
                    $total += $score->score;
                    $count++;
                }
            }
            $grade->average_score = $count > 0 ? round($total / $count, 2) : '---';
        }
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