<?php

namespace App\Repositories\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogRepository
{
    /**
     * Get a list of blogs with truncated content and titles for display.
     *
     * @param Request $request
     * @return array
     */
    public static function list(Request $request): array
    {
        try {
            // Retrieve all blogs and convert to array
            $blogList = Blog::select('*')->get()->toArray();

            // Truncate content and titles for display purposes
            foreach ($blogList as &$blog) {
                $blog['content'] = strip_tags($blog['content']);
                $blog['content'] = trim($blog['content']);
                $blog['content'] = substr($blog['content'], 0, 150);
                $blog['title'] = substr($blog['title'], 0, 50);
            }

            // Return a success response with the truncated blog data
            return ['status' => 200, 'data' => $blogList];
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Find a specific blog by its ID.
     *
     * @param Request $request
     * @param string $blog_id
     * @return array
     */
    public static function find(Request $request, string $blog_id): array
    {
        try {
            // Retrieve the blog with the given ID
            $blog = Blog::where('_id', $blog_id)->first();

            // Return a success response with the blog data
            return ['status' => 200, 'data' => $blog];
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Upsert (insert or update) a blog based on the provided data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @param string|null $blog_id The ID of the blog to update, or null if it's a new blog.
     * @return array An associative array with 'status' and 'msg' or 'error' keys.
     */
    public static function upsert($request, $blog_id = null): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required',
                'content' => 'required',
                'status' => 'required'
            ]);

            // Check if validation fails, return error response
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Check if updating an existing blog or creating a new one
            if ($blog_id) {
                $blog = Blog::where('_id', $input['_id'])->first();
            } else {
                $blog = new Blog();
            }

            // Assign values to the blog model
            $blog->title = $request->title;
            $blog->content = $request->get('content');
            $blog->status = $request->status;
            $blog->banner = $request->banner;
            $blog->banner_full_path = $request->banner_full_path;
            $blog->save();

            // Return success response
            return ['status' => 200, 'msg' => 'Blog has been updated successfully'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a blog based on the provided ID.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status' and 'msg' or 'error' keys.
     */
    public static function delete($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                '_id' => 'required'
            ]);

            // Check if validation fails, return error response
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Delete the blog with the specified ID
            Blog::where('_id', $input['_id'])->delete();

            // Return success response
            return ['status' => 200, 'msg' => 'Blog has been deleted successfully'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
