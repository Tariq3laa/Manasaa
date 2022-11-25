<?php

namespace Modules\Admin\Skill\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Skill\Entities\Lesson;
use Modules\Common\Helpers\Traits\ApiPaginator;
use Modules\Common\Http\Controllers\InitController;
use Modules\Admin\Skill\Transformers\LessonResource;

class LessonController extends InitController
{
    use ApiPaginator;

    public function index(Request $request): JsonResponse
    {
        try {
            $lessons = app(Pipeline::class)
                ->send(Lesson::query()->where('skill_id', $request->skill_id))
                ->through([
                    \Modules\Common\Filters\PaginationPipeline::class,
                    \Modules\Common\Filters\SortPipeline::class,
                ])
                ->thenReturn();
            $collection = LessonResource::collection($lessons);
            $data = $this->getPaginatedResponse($lessons, $collection);
            return $this->respondWithSuccess($data);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $model = Lesson::create($request->all());
            DB::commit();
            return $this->respondCreated([$model->id]);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Lesson::find($id);
            if ($item) {
                $item = new LessonResource($item);
                return $this->respondWithSuccess($item);
            } else {
                return $this->respondError('Lesson Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function update(Request $request, $id) :JsonResponse
    {
        try {
            DB::beginTransaction();
            $item = Lesson::find($id);
            if ($item) {
                $item->update($request->all());
                DB::commit();
                return $this->respondOk('Lesson updated successfully .');
            } else {
                return $this->respondError('Lesson Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Lesson::find($id);
            if ($item) {
                $item->delete();
                return $this->respondOk('Lesson Deleted Successfully .');
            } else {
                return $this->respondError('Lesson Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }
}
