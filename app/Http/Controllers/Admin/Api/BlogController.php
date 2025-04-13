<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\BlogRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get a list of blogs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        // Retrieve the list of blogs using the BlogRepository
        $rv = BlogRepository::list($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Get a specific blog by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $blog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBlog(Request $request, $blog_id)
    {
        // Find and retrieve the specified blog using the BlogRepository
        $rv = BlogRepository::find($request, $blog_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Upsert (create/update) a blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $blog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function upsert(Request $request, string $blog_id = null)
    {
        // Upsert (create/update) the blog using the BlogRepository
        $rv = BlogRepository::upsert($request, $blog_id);

        // Return the response as JSON
        return response()->json($rv, 200);
    }

    /**
     * Delete a blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        // Delete the blog using the BlogRepository
        $rv = BlogRepository::delete($request);

        // Return the response as JSON
        return response()->json($rv, 200);
    }
}
