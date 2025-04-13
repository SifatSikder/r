<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AwarenessEvaluationSectionResource;
use App\Models\AwarenessEvaluationSection;
use App\Models\AwarenessEvaluationSectionQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AwarenessEvaluationController extends Controller
{
    /**
     * Get all Awareness Evaluation Sections
     *
     * @param Request $request
     * @param $type
     * @return JsonResponse
     */
    public function section_list(Request $request, $type): JsonResponse
    {
        try {

            $data = AwarenessEvaluationSection::where('type', $type)->get();
            foreach ($data as $key => $value) {
                $data[$key] = new AwarenessEvaluationSectionResource($value);
            }
            return response()->json([
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new Awareness Evaluation Section
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function section_create(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {

            $data = new AwarenessEvaluationSection();
            $data->type = $request->type;
            $data->title = $request->title ?? 'Untitled';
            $data->description = $request->description ?? null;
            $data->save();
            $rv = new AwarenessEvaluationSectionResource($data);
            return response()->json([
                'data' => $rv
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing Awareness Evaluation Section
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function section_update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {

            $data = AwarenessEvaluationSection::find($id);
            if ($data == null) {
                return response()->json([
                    'error' => 'Section not found'
                ], 404);
            }

            $data->title = $request->title ?? 'Untitled';
            $data->description = $request->description ?? null;
            $data->save();

            return response()->json([
                'msg' => 'Section updated successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an existing Awareness Evaluation Section
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function section_delete(Request $request, $id): JsonResponse
    {
        try {

            $data = AwarenessEvaluationSection::find($id);
            if ($data == null) {
                return response()->json([
                    'error' => 'Section not found'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'msg' => 'Section deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function section_question_manage(Request $request): JsonResponse
    {
        $request->validate([
            'section_id' => 'required|string',
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'answer' => 'required|string',
        ]);

        try {
            if ($request->id != null) {
                $data = AwarenessEvaluationSectionQuestion::where('section_id', $request->section_id)->where('_id', $request->id)->first();
                if ($data == null) {
                    return response()->json([
                        'error' => 'Question not found'
                    ], 404);
                }
            } else {
                $data = new AwarenessEvaluationSectionQuestion();
                $data->section_id = $request->section_id;
            }

            $data->question = $request->question;
            $data->option_1 = $request->option_1;
            $data->option_2 = $request->option_2;
            $data->option_3 = $request->option_3;
            $data->option_4 = $request->option_4;
            $data->answer = $request->answer;
            $data->save();

            return response()->json([
                'data' => $data,
                'msg' => 'Question created/updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function section_question_delete(Request $request, $id): JsonResponse
    {
        $request->validate([
            'section_id' => 'required|string'
        ]);

        try {
            $data = AwarenessEvaluationSectionQuestion::where('section_id', $request->section_id)->where('_id', $request->id)->first();
            if ($data == null) {
                return response()->json([
                    'error' => 'Question not found'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'msg' => 'Question deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
