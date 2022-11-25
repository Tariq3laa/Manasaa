<?php

namespace Modules\Admin\Skill\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'id'                => $this->id,
            'answer'            => $this->answer
        ];
    }
}
