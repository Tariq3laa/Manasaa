<?php

namespace Modules\Admin\Skill\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'id'                => $this->id,
            'question'          => $this->question,
            'type'              => $this->type,
            'answers'           => AnswerResource::collection($this->answers)
        ];
    }
}
