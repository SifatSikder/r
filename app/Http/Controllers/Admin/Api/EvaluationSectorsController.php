<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\EvaluationSectorsRepository;
use Illuminate\Http\Request;

class EvaluationSectorsController extends Controller
{
    /**
     * Get all evaluation sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAll(Request $request)
    {
        // Call the GetAll method from EvaluationSectorsRepository to retrieve all evaluation sectors.
        $rv = EvaluationSectorsRepository::GetAll($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Manage evaluation sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Manage(Request $request)
    {
        // Call the Manage method from EvaluationSectorsRepository to handle the management of evaluation sectors.
        $rv = EvaluationSectorsRepository::Manage($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Get all FD (Fair Decision) sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAllFdSectors(Request $request)
    {
        // Call the GetAllFdSectors method from EvaluationSectorsRepository to retrieve all FD sectors.
        $rv = EvaluationSectorsRepository::GetAllFdSectors($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Manage FD (Fair Decision) sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ManageFdSectors(Request $request)
    {
        // Call the ManageFdSectors method from EvaluationSectorsRepository to handle the management of FD sectors.
        $rv = EvaluationSectorsRepository::ManageFdSectors($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Get all question groups associated with evaluation sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAllQuestionGroups(Request $request)
    {
        // Call the GetAllQuestionGroups method from EvaluationSectorsRepository to retrieve all question groups.
        $rv = EvaluationSectorsRepository::GetAllQuestionGroups($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Manage question groups associated with evaluation sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ManageQuestionGroups(Request $request)
    {
        // Call the ManageQuestionGroups method from EvaluationSectorsRepository to handle the management of question groups.
        $rv = EvaluationSectorsRepository::ManageQuestionGroups($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
