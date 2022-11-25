<?php

namespace Modules\Admin\Skill\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Skill\Entities\Answer;
use Modules\Admin\Skill\Entities\Lesson;

class Question extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the client that created the job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
