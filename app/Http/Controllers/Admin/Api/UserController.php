<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Get a list of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        // Delegate user listing to the UserRepository
        $rv = UserRepository::list($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // Delegate user creation to the UserRepository
        $rv = UserRepository::create($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Get details of a single user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function single(Request $request): JsonResponse
    {
        // Delegate fetching a single user to the UserRepository
        $rv = UserRepository::single($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Update user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        // Delegate user information update to the UserRepository
        $rv = UserRepository::update($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Delete a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        // Delegate user deletion to the UserRepository
        $rv = UserRepository::delete($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }
}
