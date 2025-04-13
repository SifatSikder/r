<?php

namespace App\Http\Resources;

use App\Models\AwarenessEvaluationSectionQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class AwarenessEvaluationSectionResource extends JsonResource
{
    /**
     * @var array
     */
    private $answer;

    public function __construct($resource, $answer = 1)
    {
        parent::__construct($resource);
        $this->answer = $answer;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->answer === 1){
            $questions = AwarenessEvaluationSectionQuestion::where('section_id', $this->id)->orderBy('order', 'asc')->get()->toArray();
        } else {
            $questions = AwarenessEvaluationSectionQuestion::select('question','option_1','option_2','option_3','option_4')->where('section_id', $this->id)->orderBy('order', 'asc')->get()->toArray();
            foreach ($questions as &$question) {
                $question['id'] = $question['_id'];
                $question['answer'] = "";
            }
        }
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'questions' => $questions,
        ];
    }
}
