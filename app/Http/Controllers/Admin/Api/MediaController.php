<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\MediaRepository;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Upload media file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Upload(Request $request)
    {
        // Call the Upload method from MediaRepository to handle the upload of a media file.
        $rv = MediaRepository::Upload($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
