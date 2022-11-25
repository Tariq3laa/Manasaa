<?php

namespace Modules\Admin\Skill\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Skill\Entities\Question;

class Answer extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the client that created the job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
