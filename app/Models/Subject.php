<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

class Subject extends Model
{
    protected $fillable = ['name', 'topics_count', 'grade_id'];
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
        public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function teachers() {
        return $this->belongsToMany(Teacher::class, 'teacher_subject_class');
    }
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_subject_class');
    }
}
