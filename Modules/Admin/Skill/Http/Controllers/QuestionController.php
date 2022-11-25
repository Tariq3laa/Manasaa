<?php

namespace Modules\Admin\Skill\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Skill\Entities\Answer;
use Modules\Admin\Skill\Entities\Question;
use Modules\Common\Helpers\Traits\ApiPaginator;
use Modules\Common\Http\Controllers\InitController;
use Modules\Admin\Skill\Transformers\QuestionResource;

class QuestionController extends InitController
{
    use ApiPaginator;

    public function index(Request $request): JsonResponse
    {
        try {
            $request->lesson_id ? $query = Question::query()->where('lesson_id', $request->lesson_id) : $query = Question::query();
            $questions = app(Pipeline::class)
                ->send($query)
                ->through([
                    \Modules\Common\Filters\PaginationPipeline::class,
                    \Modules\Common\Filters\SortPipeline::class,
                ])
                ->thenReturn();
            $collection = QuestionResource::collection($questions);
            $data = $this->getPaginatedResponse($questions, $collection);
            return $this->respondWithSuccess($data);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $model = Question::create([
                'question'      =>  $request->question,
                'type'          =>  $request->type,
                'lesson_id'     =>  $request->lesson_id
            ]);
            foreach ($request->answers as $answer) {
                Answer::create([
                    'answer'        =>  $answer['answer'],
                    'correct'       =>  $answer['correct'] ?? null,
                    'question_id'   =>  $model->id
                ]);
            }
            DB::commit();
            return $this->respondCreated([$model->id]);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Question::find($id);
            if ($item) {
                $item = new QuestionResource($item);
                return $this->respondWithSuccess($item);
            } else {
                return $this->respondError('Question Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function update(Request $request, $id) :JsonResponse
    {
        try {
            DB::beginTransaction();
            $item = Question::find($id);
            if ($item) {
                $item->update([
                    'question'      =>  $request->question,
                    'type'          =>  $request->type,
                    'lesson_id'     =>  $request->lesson_id
                ]);
                Answer::where('question_id', $item->id)->delete();
                foreach ($request->answers as $answer) {
                    Answer::create([
                        'answer'        =>  $answer['answer'],
                        'correct'       =>  $answer['correct'] ?? null,
                        'question_id'   =>  $item->id
                    ]);
                }
                DB::commit();
                return $this->respondOk('Question updated successfully .');
            } else {
                return $this->respondError('Question Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Question::find($id);
            if ($item) {
                $item->delete();
                return $this->respondOk('Question Deleted Successfully .');
            } else {
                return $this->respondError('Question Not Found !');
            }
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }
}
