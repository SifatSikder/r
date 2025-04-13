<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CertificateController extends Controller
{
    /**
     * Get evaluation certificate settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_certificate_settings(Request $request): JsonResponse
    {
        // Call the evaluation_certificate_settings method from CertificateRepository.
        $rv = CertificateRepository::evaluation_certificate_settings($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Update evaluation certificate settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_certificate_settings_update(Request $request): JsonResponse
    {
        // Call the evaluation_certificate_settings_update method from CertificateRepository.
        $rv = CertificateRepository::evaluation_certificate_settings_update($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Get evaluation certificates.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_certificates(Request $request): JsonResponse
    {
        // Call the evaluation_certificates method from CertificateRepository.
        $rv = CertificateRepository::evaluation_certificates($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Get participant certificates.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function participant_certificates(Request $request): JsonResponse
    {
        // Call the participant_certificates method from CertificateRepository.
        $rv = CertificateRepository::participant_certificates($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
