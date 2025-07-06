<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjectClass extends Model
{
    protected $table = 'teacher_subject_class';
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}