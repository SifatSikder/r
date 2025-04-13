<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AwarenessRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AwarenessController extends Controller
{
    /**
     * Get a list of awareness course.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        // Retrieve the list of awareness course using the AwarenessRepository
        $rv = AwarenessRepository::list($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Create a new awareness course.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // Create a new awareness course using the AwarenessRepository
        $rv = AwarenessRepository::create($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Get information about a single awareness course.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function single(Request $request, $id): JsonResponse
    {
        // Retrieve information about a single awareness course using the AwarenessRepository
        $rv = AwarenessRepository::single($request, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Update an existing awareness course.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Update an existing awareness course using the AwarenessRepository
        $rv = AwarenessRepository::update($request, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Delete a awareness course.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function delete(Request $request, $id): JsonResponse
    {
        // Delete an awareness course using the AwarenessRepository
        $rv = AwarenessRepository::delete($request, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }


    public function topic_list(Request $request, $awareness_id): JsonResponse
    {
        // Retrieve the list of awareness course topic using the AwarenessRepository
        $rv = AwarenessRepository::topic_list($request, $awareness_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_create(Request $request, $awareness_id): JsonResponse
    {
        // Create a new awareness course topic using the AwarenessRepository
        $rv = AwarenessRepository::topic_create($request, $awareness_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_update(Request $request, $awareness_id, $id): JsonResponse
    {
        // Update an existing awareness course topic using the AwarenessRepository
        $rv = AwarenessRepository::topic_update($request, $awareness_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_delete(Request $request, $awareness_id, $id): JsonResponse
    {
        // Delete an awareness course topic using the AwarenessRepository
        $rv = AwarenessRepository::topic_delete($request, $awareness_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }


    public function topic_lesson_list(Request $request, $awareness_id, $topic_id): JsonResponse
    {
        // Retrieve the list of awareness course topic lesson using the AwarenessRepository
        $rv = AwarenessRepository::topic_lesson_list($request, $awareness_id, $topic_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_lesson_create(Request $request, $awareness_id, $topic_id): JsonResponse
    {
        // Create a new awareness course topic lesson using the AwarenessRepository
        $rv = AwarenessRepository::topic_lesson_create($request, $awareness_id, $topic_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_lesson_single(Request $request, $awareness_id, $topic_id, $id): JsonResponse
    {
        // Update an existing awareness course topic lesson using the AwarenessRepository
        $rv = AwarenessRepository::topic_lesson_single($request, $awareness_id, $topic_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_lesson_update(Request $request, $awareness_id, $topic_id, $id): JsonResponse
    {
        // Update an existing awareness course topic lesson using the AwarenessRepository
        $rv = AwarenessRepository::topic_lesson_update($request, $awareness_id, $topic_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    public function topic_lesson_delete(Request $request, $awareness_id, $topic_id, $id): JsonResponse
    {
        // Delete an awareness course topic lesson using the AwarenessRepository
        $rv = AwarenessRepository::topic_lesson_delete($request, $awareness_id, $topic_id, $id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }
}
