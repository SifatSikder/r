<?php

namespace App\Repositories\Admin;

use App\Models\Blog;
use App\Models\Evaluation;
use App\Models\QuestionMitigations;
use App\Models\User;
use App\Models\WorkshopCertificates;
use App\Models\Workshops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopRepository
{
    /**
     * Retrieves a list of workshops based on the provided keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function list($request): array
    {
        try {
            // Retrieve keyword from the request
            $keyword = $request->keyword ?? null;

            // Fetch workshops based on keyword and order them by date
            $data = Workshops::select('*')->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('title', 'LIKE', '%' . $keyword . '%');
                    $q->orWhere('venue', 'LIKE', '%' . $keyword . '%');
                }
            })->orderBy('date', 'asc')->get();

            // Format date and check if workshop is expired
            foreach ($data as &$each) {
                $each['date'] = date('d M, Y', strtotime($each['date']));
                $each['expired'] = strtotime($each['date']) < strtotime(date('Y-m-d')) ? 1 : 0;
            }

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Creates a new workshop based on the provided input.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function create($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'title' => 'required',
                'code' => 'required|unique:workshops,code',
                'venue' => 'required',
                'date' => 'required|date',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Create a new workshop
            Workshops::create([
                'title' => $input['title'],
                'code' => $input['code'],
                'venue' => $input['venue'],
                'date' => date('Y-m-d', strtotime($input['date']))
            ]);

            // Return success response
            return ['status' => 200, 'msg' => 'A new workshop has been created successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves information about a single workshop.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function single($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'workshop_id' => 'required',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Fetch information about the specified workshop
            $data = Workshops::where('_id', $input['workshop_id'])->first();

            // Format date
            if ($data != null) {
                $data->date_format = date('d M, Y', strtotime($data->date));
            }

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves certificates related to a specific workshop.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function certificates($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'workshop_id' => 'required',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Fetch certificates related to the specified workshop
            $data = WorkshopCertificates::where('workshop', $input['workshop_id'])->get()->toArray();

            // Format file path to include asset URL
            foreach ($data as &$each) {
                $each['file_path'] = asset('storage/media/certificate/' . $each['file_path']);
            }

            // Return success response with data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Updates information about a workshop based on the provided input.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function update($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                '_id' => 'required',
                'title' => 'required',
                'code' => 'required|unique:workshops,code,' . $request->get('_id') . ',_id',
                'venue' => 'required',
                'date' => 'required|date',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Update workshop information
            Workshops::where('_id', $request->get('_id'))->update([
                'title' => $input['title'],
                'code' => $input['code'],
                'venue' => $input['venue'],
                'date' => date('Y-m-d', strtotime($input['date']))
            ]);

            // Return success response
            return ['status' => 200, 'msg' => 'Workshop information has been updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Deletes information about a workshop and associated certificates.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function delete($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'workshop_id' => 'required',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Fetch the workshop to be deleted
            $workshop = Workshops::where('_id', $request->get('workshop_id'))->first();

            // Delete associated certificates and the workshop
            if ($workshop != null) {
                WorkshopCertificates::where('workshop', $workshop->_id)->delete();
                Workshops::where('_id', $request->get('workshop_id'))->delete();
            }

            // Return success response
            return ['status' => 200, 'msg' => 'Workshop information has been removed successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
