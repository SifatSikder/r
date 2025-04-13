<?php

namespace App\Repositories\Admin;

use App\Models\Questionnaires;
use Illuminate\Support\Facades\Validator;

class QuestionRepository
{
    /**
     * Retrieves a list of questions based on specified criteria.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function List($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'category' => 'required'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Fetch questions based on specified criteria
            $Questions = Questionnaires::select('*')
                ->where(function ($q) use ($request) {
                    if (!empty($request->category)) {
                        $q->where('category', $request->category);
                    }
                    if (!empty($request->sector)) {
                        $q->where('sector', $request->sector);
                    }
                    if (!empty($request->sub_sector)) {
                        $q->where('sub_sector', $request->sub_sector);
                    }
                    if (!empty($request->group)) {
                        $q->where('group', $request->group);
                    }
                })
                ->get()->toArray();

            // Return success response with data
            return ['status' => 200, 'data' => $Questions];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Manages the addition or modification of a question.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function Manage($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'type' => 'required',
                'category' => 'required',
                'question' => 'required',
                'option_1' => 'required|array'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Check if the question already exists, and either update or create a new one
            if (isset($input['_id'])) {
                $Question = Questionnaires::where('_id', $input['_id'])->first();
            } else {
                $Question = new Questionnaires();
            }

            // Set question attributes
            $Question->type = $request->type;
            $Question->category = $request->category;
            $Question->sector = $request->sector ?? '';
            $Question->sub_sector = $request->sub_sector ?? '';
            $Question->group = $request->group ?? '';
            $Question->question = $request->question;
            $Question->question_hints = $request->question_hints ?? '';
            $Question->option_1 = $request->option_1;
            $Question->option_2 = $request->option_2 ?? null;
            $Question->option_3 = $request->option_3 ?? null;
            $Question->option_4 = $request->option_4 ?? null;
            $Question->save();

            // Return success response
            return ['status' => 200, 'msg' => 'Question has been added or updated successfully'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Deletes a question based on the provided _id.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function Delete($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                '_id' => 'required'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Delete the question based on the provided _id
            Questionnaires::where('_id', $input['_id'])->delete();

            // Return success response
            return ['status' => 200, 'msg' => 'Question has been deleted successfully'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
