<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Get a list of questions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function List(Request $request)
    {
        // Call the List method from QuestionRepository to retrieve a list of questions.
        $rv = QuestionRepository::List($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Manage questions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Manage(Request $request)
    {
        // Call the Manage method from QuestionRepository to handle the management of questions.
        $rv = QuestionRepository::Manage($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Delete a question.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(Request $request)
    {
        // Call the Delete method from QuestionRepository to delete a question.
        $rv = QuestionRepository::Delete($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
