<?php

namespace App\Repositories\Admin;

use App\Models\Awareness;
use App\Models\AwarenessTopic;
use App\Models\AwarenessTopicLesson;
use App\Models\AwarenessTopicLessonQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AwarenessRepository
{
    /**
     * Retrieves a list of awareness course based on the provided keyword.
     *
     * @param Request $request
     * @return array
     */
    public static function list(Request $request): array
    {
        try {
            // Retrieve keyword from the request
            $keyword = $request->keyword ?? null;

            // Fetch awareness courses based on keyword and order them by date
            $data = Awareness::select('*')->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('title', 'LIKE', '%' . $keyword . '%');
                }
            })->orderBy('id', 'desc')->get();

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Creates a new awareness course based on the provided input.
     *
     * @param Request $request
     * @return array
     */
    public static function create($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'type' => 'required|in:free,premium',
                'category' => 'required|in:public,private',
                'title' => 'required|string',
                'certificate' => 'required|in:0,1',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Create a new awareness course
            Awareness::create([
                'type' => $input['type'],
                'category' => $input['category'],
                'title' => $input['title'],
                'slug' => Str::slug($input['title']),
                'description' => $input['description'] ?? null,
                'banner' => $input['banner'] ?? null,
                'certificate' => $input['certificate'] ?? 0
            ]);

            // Return success response
            return ['status' => 200, 'msg' => 'A new awareness course has been created successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves information about a single awareness course.
     *
     * @param $request
     * @param $id
     * @return array
     */
    public static function single($request, $id): array
    {
        try {
            // Fetch information about the specified awareness course
            $data = Awareness::where('_id', $id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course found.'];
            }

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Updates information about an awareness course based on the provided input.
     *
     * @param $request
     * @param $id
     * @return array
     */
    public static function update($request, $id): array
    {
        try {

            // Fetch information about the specified awareness course
            $data = Awareness::where('_id', $id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course found.'];
            }

            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'type' => 'required|in:free,premium',
                'category' => 'required|in:public,private',
                'title' => 'required|string',
                'certificate' => 'required|in:0,1',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            $data->type = $input['type'];
            $data->category = $input['category'];
            $data->title = $input['title'];
            $data->slug = Str::slug($input['title']);
            $data->description = $input['description'] ?? null;
            $data->banner = $input['banner'] ?? null;
            $data->certificate = $input['certificate'] ?? 0;
            $data->save();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course information has been updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Deletes information about an awareness course and associated certificates.
     *
     * @param $request
     * @param $id
     * @return array
     */
    public static function delete($request, $id): array
    {
        try {

            // Fetch information about the specified awareness course
            $data = Awareness::where('_id', $id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course found.'];
            }


            // Fetch the awareness course to be deleted
            $data->delete();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course information has been removed successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    public static function topic_list(Request $request, $awareness_id): array
    {
        try {
            // Retrieve keyword from the request
            $keyword = $request->keyword ?? null;

            // Fetch awareness course topics based on keyword and order them by date
            $data = AwarenessTopic::select('*')
                ->where('awareness_id', $awareness_id)
                ->where(function ($q) use ($keyword) {
                    if (!empty($keyword)) {
                        $q->where('title', 'LIKE', '%' . $keyword . '%');
                    }
                })
                ->orderBy('created_at', 'asc')
                ->get()->toArray();
            foreach ($data as &$d) {
                $d['lessons'] = AwarenessTopicLesson::select('*')
                    ->where('awareness_id', $awareness_id)
                    ->where('topic_id', $d['_id'])
                    ->orderBy('created_at', 'asc')
                    ->get()->toArray();
            }

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_create($request, $awareness_id): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required|string'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Create a new awareness course topic
            AwarenessTopic::create([
                'awareness_id' => $awareness_id,
                'title' => $input['title']
            ]);

            // Return success response
            return ['status' => 200, 'msg' => 'A new awareness course topic has been created successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_update($request, $awareness_id, $id): array
    {
        try {

            // Fetch information about the specified awareness course topic
            $data = AwarenessTopic::where('_id', $id)->where('awareness_id', $awareness_id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course topic found.'];
            }

            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required|string'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            $data->title = $input['title'];
            $data->save();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course topic information has been updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_delete($request, $awareness_id, $id): array
    {
        try {

            // Fetch information about the specified awareness course topic
            $data = AwarenessTopic::where('_id', $id)->where('awareness_id', $awareness_id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course topic found.'];
            }


            // Fetch the awareness course topic to be deleted
            $data->delete();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course topic information has been removed successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    public static function topic_lesson_list(Request $request, $awareness_id, $topic_id): array
    {
        try {
            // Retrieve keyword from the request
            $keyword = $request->keyword ?? null;

            // Fetch awareness course topic lessons based on keyword and order them by date
            $data = AwarenessTopicLesson::select('*')
                ->where('awareness_id', $awareness_id)
                ->where('topic_id', $topic_id)
                ->where(function ($q) use ($keyword) {
                    if (!empty($keyword)) {
                        $q->where('title', 'LIKE', '%' . $keyword . '%');
                    }
                })->orderBy('id', 'desc')->get();

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_lesson_create($request, $awareness_id, $topic_id): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required|string',
                'is_quiz' => 'required|in:0,1',
                'is_final_exam' => 'required|in:0,1',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            $description = null;
            if(!empty($input['description'])){
                dd($input['description']);
                preg_match_all('/<img[^>]+src=["\'](data:image\/[^"\']+)["\'][^>]*>/', $input['description'], $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $base64Image) {
                        // Decode base64
                        preg_match('/data:image\/(\w+);base64,/', $base64Image, $imageType);
                        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
                        $imageData = str_replace(' ', '+', $imageData);
                        $imageData = base64_decode($imageData);

                        // Generate a unique filename
                        $imageExtension = $imageType[1] ?? 'png';
                        $imageName = 'uploads/' . date('Y/m/d') . '/' . Str::uuid() . '.' . $imageExtension;

                        // Store the image in public disk
                        $filePath = Storage::disk('public')->put('/editor/image', $imageData);
//                        Storage::disk('public')->put($imageName, $imageData);

                        // Generate URL
                        $url = asset('storage/' . $filePath);

                        // Replace base64 with image URL
                        $description = str_replace($base64Image, $url, $input['description']);
                    }
                }
            }

            // Create a new awareness course topic lesson
            $lesson = AwarenessTopicLesson::create([
                'awareness_id' => $awareness_id,
                'topic_id' => $topic_id,
                'title' => $input['title'],
                'description' => $description,
                'is_quiz' => $input['is_quiz'] ?? 0,
                'is_final_exam' => $input['is_final_exam'] ?? 0
            ]);

            // Return success response
            return ['status' => 200, 'data' => ['lesson_id' => $lesson->_id], 'msg' => 'A new awareness course topic lesson has been created successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_lesson_single($request, $awareness_id, $topic_id, $id): array
    {
        try {

            // Fetch information about the specified awareness course topic lesson
            $data = AwarenessTopicLesson::where('_id', $id)->where('awareness_id', $awareness_id)->where('topic_id', $topic_id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course topic lesson found.'];
            }

            if($data->is_quiz == 1){
                $data->questions = AwarenessTopicLessonQuestion::where('awareness_id', $awareness_id)
                    ->where('topic_id', $topic_id)
                    ->where('lesson_id', $data->_id)
                    ->get()
                    ->toArray();;
            }

            // Return success response
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_lesson_update($request, $awareness_id, $topic_id, $id): array
    {
        try {

            // Fetch information about the specified awareness course topic lesson
            $data = AwarenessTopicLesson::where('_id', $id)->where('awareness_id', $awareness_id)->where('topic_id', $topic_id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course topic lesson found.'];
            }

            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required|string',
                'is_quiz' => 'required|in:0,1',
                'is_final_exam' => 'required|in:0,1',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            $description = null;
            if(!empty($input['description'])){
                $description = $input['description'];

                $htmlDom = new \DOMDocument();
                @$htmlDom->loadHTML($description);
                $imageTags = $htmlDom->getElementsByTagName('img');
                if (count($imageTags) > 0) {
                    foreach ($imageTags as $imageTag) {
                        $imgSrc = $imageTag->getAttribute('src');
                        if (strpos($imgSrc, ';base64')) {
                            $imgdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgSrc));
                            $file_name = time() . '-' . uniqid() . '.png';
                            $filePath = 'editor/image/' . $file_name;
                            Storage::disk('public')->put($filePath, $imgdata);
                            $filePath = asset('storage/' . $filePath);
                            $description = str_replace($imgSrc, $filePath, $description);
                        }
                    }
                }

            }

            $data->title = $input['title'];
            $data->description = $description;
            $data->is_quiz = $input['is_quiz'] ?? 0;
            $data->is_final_exam = $input['is_final_exam'] ?? 0;
            $data->save();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course topic lesson information has been updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public static function topic_lesson_delete($request, $awareness_id, $topic_id, $id): array
    {
        try {

            // Fetch information about the specified awareness course topic lesson
            $data = AwarenessTopicLesson::where('_id', $id)->where('awareness_id', $awareness_id)->where('topic_id', $topic_id)->first();
            // Check if the course exists
            if ($data == null) {
                return ['status' => 500, 'error' => 'No awareness course topic lesson found.'];
            }

            // Fetch the awareness course topic to be deleted
            $data->delete();

            // Return success response
            return ['status' => 200, 'msg' => 'Awareness course topic lesson information has been removed successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
