<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'grade_id'];
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'grade_id', 'grade_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject_class');
    }
}
