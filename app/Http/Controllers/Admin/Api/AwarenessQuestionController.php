<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\AwarenessTopicLessonQuestion;
use App\Repositories\Admin\AwarenessQuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AwarenessQuestionController extends Controller
{
    public function manage(Request $request, $awareness_id, $topic_id, $lesson_id): JsonResponse
    {
        // Create a new awareness course topic lesson question using the AwarenessQuestionRepository
        $rv = AwarenessQuestionRepository::manage($request, $awareness_id, $topic_id, $lesson_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function delete(Request $request, $awareness_id, $topic_id, $lesson_id, $id): JsonResponse
    {
        // Delete awareness course topic lesson question using the AwarenessQuestionRepository
        $rv = AwarenessQuestionRepository::delete($request, $awareness_id, $topic_id, $lesson_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

}
