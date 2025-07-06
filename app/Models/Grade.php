<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\SchoolClass;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name'];
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function students()
    {
        return $this->hasManyThrough(Student::class, SchoolClass::class);
    }
    public function teachers()
    {
        return $this->hasManyThrough(Teacher::class, Subject::class);
    }
}