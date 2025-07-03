<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'school_class_id',
    ];
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
