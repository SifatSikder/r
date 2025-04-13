<?php

namespace App\Repositories\Admin;

use App\Models\Blog;
use App\Models\CertificateSettings;
use App\Models\Evaluation;
use App\Models\EvaluationCertificates;
use App\Models\QuestionMitigations;
use App\Models\User;
use App\Models\WorkshopCertificates;
use App\Models\Workshops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificateRepository
{
    /**
     * Get or create evaluation certificate settings based on the provided type.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status' and 'data' or 'error' keys.
     */
    public static function evaluation_certificate_settings($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'type' => 'required',
            ]);

            // Check if validation fails, return error response
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve or create evaluation certificate settings based on the provided type
            $data = CertificateSettings::where('type', $input['type'])->first();

            if ($data == null) {
                $data = CertificateSettings::create([
                    'type' => $input['type'],
                    'certificate_logo' => null,
                    'certificate_bg' => null,
                    'participant_name_color' => '#000000',
                    'participant_name_border_color' => '#E5B145',
                    'participant_name_font_size' => '50',
                    'description_letter' => '',
                    'signature' => ''
                ]);
            }

            // Append full paths to certificate_logo and certificate_bg if they are not null
            if ($data->certificate_logo != null) {
                $data->certificate_logo_full = asset('storage/media/image/'.$data->certificate_logo);
            }
            if ($data->certificate_bg != null) {
                $data->certificate_bg_full = asset('storage/media/image/'.$data->certificate_bg);
            }

            // Return success response with the data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update evaluation certificate settings based on the provided input.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'msg', or 'error' keys.
     */
    public static function evaluation_certificate_settings_update($request): array
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'type' => 'required',
                'certificate_logo' => 'required',
                'certificate_bg' => 'required',
                'participant_name_color' => 'required',
                'participant_name_border_color' => 'required',
                'participant_name_font_size' => 'required',
                'description_letter' => 'required',
                'signature' => 'required',
            ]);

            // Check if validation fails, return error response
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Update evaluation certificate settings based on the provided type
            CertificateSettings::where('type', $input['type'])->update([
                'certificate_logo' => $input['certificate_logo'],
                'certificate_bg' => $input['certificate_bg'],
                'participant_name_color' => $input['participant_name_color'],
                'participant_name_border_color' => $input['participant_name_border_color'],
                'participant_name_font_size' => $input['participant_name_font_size'],
                'description_letter' => $input['description_letter'],
                'signature' => $input['signature']
            ]);

            // Return success response
            return ['status' => 200, 'msg' => 'Certificate settings has been updated successfully'];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieve evaluation certificates and associated information.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'data', or 'error' keys.
     */
    public static function evaluation_certificates($request): array
    {
        try {
            // Retrieve evaluation certificates ordered by creation date in descending order
            $data = EvaluationCertificates::orderBy('created_at', 'desc')->get()->toArray();

            // Iterate through each certificate data to enhance and format information
            foreach ($data as &$each) {
                // Retrieve project information associated with the evaluation certificate
                $each['evaluation'] = Evaluation::select('project')->where('_id', $each['evaluation_id'])->first();

                // Set the file path using the asset function
                $each['file_path'] = asset('storage/media/certificate/' . $each['file_path']);

                // Format the creation date
                $each['created_at'] = date('d M, Y', strtotime($each['created_at']));
            }

            // Return success response with the enhanced data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieve participant certificates associated with workshops.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return array An associative array with 'status', 'data', or 'error' keys.
     */
    public static function participant_certificates($request): array
    {
        try {
            // Retrieve participant certificates ordered by creation date in descending order
            $data = WorkshopCertificates::orderBy('created_at', 'desc')->get()->toArray();

            // Iterate through each certificate data to enhance and format information
            foreach ($data as &$each) {
                // Retrieve workshop information associated with the participant certificate
                $each['workshop'] = Workshops::where('_id', $each['workshop'])->first();

                // Set the file path using the asset function
                $each['file_path'] = asset('storage/media/certificate/' . $each['file_path']);

                // Format the creation date
                $each['created_at'] = date('d M, Y', strtotime($each['created_at']));
            }

            // Return success response with the enhanced data
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Return error response with the exception message
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


}
