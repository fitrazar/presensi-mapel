<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $guarded = ['id'];

    public function getFullClassNameAttribute()
    {
        $majorName = $this?->major ? $this?->major?->acronym : '';
        return "{$this?->level} {$majorName} {$this?->class_number}";
    }

    /**
     * Get the major that owns the Grade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    /**
     * Get all of the students for the Grade
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_id');
    }


    /**
     * Get all of the subjects for the Grade
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class, 'grade_id');
    }

    /**
     * Get the roommate associated with the Grade
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roommate(): HasOne
    {
        return $this->hasOne(Teacher::class, 'grade_id');
    }

}