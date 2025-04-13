<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\WorkshopRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WorkshopController extends Controller
{
    /**
     * Get a list of workshops.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        // Retrieve the list of workshops using the WorkshopRepository
        $rv = WorkshopRepository::list($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Create a new workshop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // Create a new workshop using the WorkshopRepository
        $rv = WorkshopRepository::create($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Get information about a single workshop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function single(Request $request): JsonResponse
    {
        // Retrieve information about a single workshop using the WorkshopRepository
        $rv = WorkshopRepository::single($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Get certificates for a workshop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function certificates(Request $request): JsonResponse
    {
        // Retrieve certificates for a workshop using the WorkshopRepository
        $rv = WorkshopRepository::certificates($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Update an existing workshop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        // Update an existing workshop using the WorkshopRepository
        $rv = WorkshopRepository::update($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Delete a workshop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        // Delete a workshop using the WorkshopRepository
        $rv = WorkshopRepository::delete($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }
}
