<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\SchoolClass;

class Teacher extends Model
{
    protected $fillable = [
    'first_name',
    'last_name',
    'national_code',
    'phone',
    'address',
    'education_level',
    ];
    public function classes() {
        return $this->belongsToMany(SchoolClass::class, 'teacher_subject_class');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject_class');
    }
    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_subject_class');
    }
}
