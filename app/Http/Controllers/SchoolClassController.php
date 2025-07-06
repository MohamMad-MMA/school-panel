<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\Subject;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with(['students', 'teachers', 'students.scores'])->get();
        foreach ($classes as $class) {
            $class->students_count = $class->students->count();
            $class->teachers_count = $class->teachers->unique('id')->count();
            $scores = $class->students->flatMap(function ($student) {
                return $student->scores->pluck('score');
            })->filter();
            $class->average_score = $scores->count()
                ? round($scores->avg(), 2)
                : null;
        }
        return view('classes.index', compact('classes'));
    }
    public function grade()
    {
        return $this->belongsTo(\App\Models\Grade::class);
    }
    public function create()
    {
        $grades = Grade::all();
        return view('classes.create', compact('grades'));
    }
    public function edit($id)
    {
        $class = \App\Models\SchoolClass::findOrFail($id);
        $grades = \App\Models\Grade::all();
        return view('classes.edit', compact('class', 'grades'));
    }
    public function destroy($id)
    {
        $class = \App\Models\SchoolClass::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'کلاس با موفقیت حذف شد.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:school_classes,name',
            'grade_id' => 'required|exists:grades,id',
        ], [
            'name.unique' => 'کلاسی با این نام قبلاً ثبت شده است.',
        ]);

        SchoolClass::create($request->all());
        return redirect()->route('school-classes.index');
    }
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:school_classes,name,' . $schoolClass->id,
            'grade_id' => 'required|exists:grades,id',
        ], [
            'name.unique' => 'کلاسی با این نام قبلاً ثبت شده است.',
        ]);
        $schoolClass->update($request->all());
        return redirect()->route('school-classes.index');
    }
    public function show(SchoolClass $class)
    {
        $class->load('grade');
        $students = $class->students()->with('scores')->get();
        foreach ($students as $student) {
            $total = 0;
            $count = 0;
            foreach ($student->scores as $score) {
                $total += $score->score;
                $count++;
            }
            $student->average = $count > 0 ? $total / $count : null;
        }
        $teacherPairs = DB::table('teacher_subject_class')
            ->where('school_class_id', $class->id)
            ->get();
        $teachers = [];
        foreach ($teacherPairs as $pair) {
            $teacher = Teacher::find($pair->teacher_id);
            $subject = Subject::find($pair->subject_id);
            if ($teacher && $subject) {
                $avgScore = DB::table('scores')
                    ->join('students', 'scores.student_id', '=', 'students.id')
                    ->where('students.school_class_id', $class->id)
                    ->where('scores.subject_id', $subject->id)
                    ->avg('score');

                $teachers[] = [
                    'teacher' => $teacher,
                    'subject' => $subject,
                    'average' => $avgScore !== null ? round($avgScore, 2) : null,
                ];
            }
        }
        return view('classes.show', [
            'schoolClass' => $class,
            'students' => $students,
            'teachers' => $teachers,
        ]);
    }
}