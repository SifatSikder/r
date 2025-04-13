<?php

namespace App\Repositories\Admin;

use App\Models\AwarenessTopicLessonQuestion;

class AwarenessQuestionRepository
{
    public static function manage($request, $awareness_id, $topic_id, $lesson_id): array
    {
        $request->validate([
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'answer' => 'required|string',
        ]);

        try {
            if ($request->_id != null) {
                $data = AwarenessTopicLessonQuestion::where('awareness_id', $awareness_id)
                    ->where('topic_id', $topic_id)
                    ->where('lesson_id', $lesson_id)
                    ->where('_id', $request->_id)
                    ->first();
                if ($data == null) {
                    return ['status' => 404, 'error' => 'Question not found'];
                }
            } else {
                $data = new AwarenessTopicLessonQuestion();
                $data->awareness_id = $awareness_id;
                $data->topic_id = $topic_id;
                $data->lesson_id = $lesson_id;
            }

            $data->question = $request->question;
            $data->option_1 = $request->option_1;
            $data->option_2 = $request->option_2;
            $data->option_3 = $request->option_3;
            $data->option_4 = $request->option_4;
            $data->answer = $request->answer;
            $data->save();

            return [
                'data' => $data,
                'msg' => 'Question created/updated successfully'
            ];

        } catch (\Exception $e) {
            return ['status' => 500, 'error' => $e->getMessage()];
        }

    }

    public static function delete($request, $awareness_id, $topic_id, $lesson_id, $id): array
    {
        try {
            $data = AwarenessTopicLessonQuestion::where('awareness_id', $awareness_id)
                ->where('topic_id', $topic_id)
                ->where('lesson_id', $lesson_id)
                ->where('_id', $id)
                ->first();
            if ($data == null) {
                return ['status' => 404, 'error' => 'Question not found'];
            }

            $data->delete();

            return ['msg' => 'Question deleted successfully'];

        } catch (\Exception $e) {
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
