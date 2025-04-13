<?php

namespace App\Http\Controllers;

use App\Http\Resources\AwarenessEvaluationSectionResource;
use App\Models\AwarenessEvaluationSection;
use App\Models\AwarenessEvaluationSectionQuestion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AwarenessEvaluationController extends BaseController
{
    public function get_awareness_evaluation(Request $request, $type)
    {
        $rv = [];

        $data = AwarenessEvaluationSection::where('type', $type)->get();
        foreach ($data as &$d) {
            $rv[] = AwarenessEvaluationSectionResource::make($d, 0);
        }

        return response()->json([
            'data' => $rv
        ], 200);
    }

    public function post_awareness_evaluation(Request $request, $type)
    {
        $input = $request->input();

        $data = AwarenessEvaluationSection::select('title')->where('type', $type)->get()->toArray();
        foreach ($data as &$d) {
            $d['questions'] = AwarenessEvaluationSectionQuestion::select('question','answer')->where('section_id', $d['_id'])->get()->toArray();
            foreach ($d['questions'] as &$q) {
                $q['result'] = 0;
                if(isset($input['section_'.$d['_id'].'_question_'.$q['_id']]) && $input['section_'.$d['_id'].'_question_'.$q['_id']] == $q['answer']) {
                    $q['result'] = 1;
                }
            }
        }

        return response()->json([
            'data' => $data
        ], 200);
    }
}
