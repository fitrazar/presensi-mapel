<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $guarded = ['id'];

    /**
     * Get all of the subjectTeachers for the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjectTeachers(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class, 'subject_id');
    }
}
