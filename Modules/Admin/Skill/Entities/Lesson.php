<?php

namespace Modules\Admin\Skill\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Skill\Entities\Skill;

class Lesson extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the client that created the job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
