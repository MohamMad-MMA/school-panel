<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Score;


class StudentController extends Controller
{
    public function transcript(Student $student)
    {
        $gradeId = $student->schoolClass->grade_id;
        $subjects = Subject::where('grade_id', $gradeId)->with(['scores' => function ($q) use ($student) {
            $q->where('student_id', $student->id);
        }, 'teachers'])->get();
        $average = $subjects->pluck('scores')->flatten()->pluck('score')->filter()->avg();
        return view('students.transcript', compact('student', 'subjects', 'average'));

    }
    public function index()
    {
        $students = Student::with('schoolClass')->get();
        return view('students.index', compact('students'));
    }
    public function create()
    {
        $classes = SchoolClass::all();
        return view('students.create', compact('classes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'national_code' => 'required|string|max:10|unique:students,national_code',
            'school_class_id' => 'required|exists:school_classes,id',
        ], [
            'national_code.unique' => 'دانش‌آموزی با این کد ملی قبلاً ثبت شده است.',
        ]);
        Student::create($request->all());
        return redirect()->route('students.index');
    }
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'national_code' => 'required|unique:students,national_code,' . $student->id,
            'school_class_id' => 'required|exists:school_classes,id',
        ], [
                'national_code.unique' => 'دانش‌آموزی با این کد ملی قبلاً ثبت شده است.',
            ]);
        
        $student->update($request->all());
        return redirect()->route('students.index');
    }
    public function show(string $id)
    {
        
    }
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('students.edit', compact('student', 'classes'));
    }
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'دانش‌آموز با موفقیت حذف شد.');
    }
    public function updateScore(Request $request, Student $student, Subject $subject)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:20',
        ]);

        Score::updateOrCreate(
            ['student_id' => $student->id, 'subject_id' => $subject->id],
            ['score' => $request->score]
        );

        return back()->with('success', 'نمره ثبت شد.');
    }
    public function storeScore(Request $request, Student $student, Subject $subject)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:20'
        ]);

        Score::updateOrCreate(
            ['student_id' => $student->id, 'subject_id' => $subject->id],
            ['score' => $request->score]
        );

        return back()->with('success', 'نمره ثبت شد');
    }

}
