<?php

namespace Modules\Admin\Skill\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'id'            => $this->id,
            'name'          => $this->name,
            'url'        => $this->url,
        ];
    }
}
