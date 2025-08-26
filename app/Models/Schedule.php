<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $guarded = ['id'];
    /**
     * Get the subjectTeacher that owns the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subjectTeacher(): BelongsTo
    {
        return $this->belongsTo(SubjectTeacher::class, 'subject_teacher_id');
    }

    /**
     * Get all of the attendances for the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'schedule_id');
    }
}