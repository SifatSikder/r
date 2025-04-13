<?php

namespace App;

use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;

class Helpers
{
    /**
     * Format a number with two decimal places.
     *
     * @param float $number
     * @return string
     */
    public static function num2format($number)
    {
        return number_format($number, 2, '.', '');
    }

    /**
     * Ask a question to the ChatGPT model and get the response.
     *
     * @param string $question
     * @return string|null
     */
    public static function askChatGPT($question)
    {
        $curl = curl_init();
        $openapiKey = getenv('OPENAI_API_KEY');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "model": "gpt-3.5-turbo",
                "messages": [
                    {"role": "system", "content": "You are a Multi-Scale Operation-assurance Evaluation Tool for AI Systems"},
                    {"role": "user", "content": "' . $question . '"}]}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openapiKey
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        // Parse the response and extract the content from the first choice
        $response = json_decode($response, true);
        $content = null;
        if (isset($response['choices']) && isset($response['choices'][0])) {
            $content = nl2br($response['choices'][0]['message']['content']);
        }

        return $content;
    }


    public static function verifyRecaptcha($token)
    {
        try {
            $param = array(
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $token,
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $param,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
            return $response;

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Parse the video ID from a YouTube video link.
     *
     * @param string $link
     * @return string|null
     */
    public static function parseYoutubeVideoId($link)
    {
        $video_id = explode("?v=", $link);
        if (empty($video_id[1])) {
            $video_id = explode("/v/", $link);
        }
        $video_id = explode("&", $video_id[1] ?? '');
        return $video_id[0] ?? null;
    }
}
