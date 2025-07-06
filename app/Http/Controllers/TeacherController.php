<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

    $teachers = Teacher::with(['subjects.classes'])->get();

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $teachers = Teacher::with(['subjectClasses.subject', 'subjectClasses.schoolClass'])->get();
        foreach ($teachers as $teacher) {
            $subjectAverages = [];
            foreach ($teacher->subjects as $subject) {
                $avg = $subject->scores->pluck('score')->filter()->avg();
                if (!is_null($avg)) {
                    $subjectAverages[] = $avg;
                }
            }
            $teacher->average_of_averages = count($subjectAverages)
                ? round(array_sum($subjectAverages) / count($subjectAverages), 2)
                : null;
        }
        return view('teachers.index', compact('teachers'));
    }
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'معلم با موفقیت حذف شد.');
    }
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::with('grade.classes')->get();
        $currentPairs = DB::table('teacher_subject_class')
            ->where('teacher_id', $teacher->id)
            ->get()
            ->map(function ($item) {
                return $item->subject_id . '_' . $item->school_class_id;
            })
            ->toArray();
        return view('teachers.edit', compact('teacher', 'subjects', 'currentPairs'));
    }
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'national_code' => ['required', Rule::unique('teachers')->ignore($teacher->id)],
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'education_level' => 'required|string|max:100',
            'subjects_classes' => 'array',
        ]);
        $teacher->update($request->only([
            'first_name', 'last_name', 'national_code',
            'birthdate', 'phone', 'address', 'education_level'
        ]));
        DB::table('teacher_subject_class')->where('teacher_id', $teacher->id)->delete();
        if ($request->has('subjects_classes')) {
            foreach ($request->subjects_classes as $pair) {
                [$subjectId, $classId] = explode('_', $pair);
                DB::table('teacher_subject_class')->insert([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subjectId,
                    'school_class_id' => $classId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return redirect()->route('teachers.index')->with('success', 'معلم با موفقیت ویرایش شد.');
    }
    public function create()
    {
        $subjects = Subject::with('grade.classes')->get();
        return view('teachers.create', compact('subjects'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'national_code' => 'required|unique:teachers,national_code',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:100',
            'subjects_classes' => 'required|array',
            'subjects_classes.*' => ['required', 'regex:/^\d+_\d+$/'], // subjectId_classId
        ], [
                'national_code.unique' => 'معلمی با این کد ملی قبلاً ثبت شده است.',
            ]);
        $teacher = Teacher::create($request->except('subjects_classes'));
        foreach ($request->subjects_classes as $pair) {
            [$subjectId, $classId] = explode('_', $pair);
            $exists = DB::table('teacher_subject_class')
                ->where('subject_id', $subjectId)
                ->where('school_class_id', $classId)
                ->exists();

            if (!$exists) {
                $teacher->subjects()->attach($subjectId, ['school_class_id' => $classId]);
            }
        }
        return redirect()->route('teachers.index');
    }
    public function show($id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);
        return view('teachers.show', compact('teacher'));
    }
}