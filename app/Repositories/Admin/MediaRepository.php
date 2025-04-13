<?php

namespace App\Repositories\Admin;

use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaRepository
{
    /**
     * Uploads media file and saves information in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function Upload($request)
    {
        try {
            // Retrieve all input data from the request
            $input = $request->all();

            // Validate the input data
            $validator = Validator::make($input, [
                'file' => 'required|file',
                'media_type' => 'nullable|integer', // 1. image, 2. video, 3. file
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Set default media_type to 1 (image) if not provided
            $input['media_type'] = $request->file('media_type') ?? 1;

            // Get the uploaded file
            $image_file = $request->file('file');

            // Extract file attributes
            $attrs = array(
                'filename' => $image_file->getClientOriginalName(),
                'extension' => $image_file->getClientOriginalExtension(),
                'size' => $image_file->getSize(),
                'mimeType' => $image_file->getMimeType()
            );

            // Determine storage path based on media_type
            if ($input['media_type'] == 1) {
                $filePath = Storage::disk('public')->put('/media/image', $input['file']);
            } else {
                // Generate a unique file name for non-image files
                $file_name = time() . '-' . strtolower(str_replace(' ', '-', $attrs['filename']));
                $filePath = '/media/file/' . $file_name;
                Storage::disk('public')->put($filePath, file_get_contents($image_file));
            }

            // Extract new file name
            $new_name = basename($filePath);

            // Create a new Media model instance
            $MediaModel = new Media();

            // Set model attributes
            $MediaModel->file_path = $new_name;
            $MediaModel->media_type = $input['media_type'];
            $MediaModel->attrs = json_encode($attrs, true);
            $MediaModel->created_at = Carbon::now();

            // Save the model to the database
            $MediaModel->save();

            // Return success response with data and file name
            return ['status' => 200, 'data' => $MediaModel->toArray(), 'file_name' => $attrs['filename']];
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
