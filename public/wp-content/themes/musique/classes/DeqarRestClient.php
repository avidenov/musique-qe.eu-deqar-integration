<?php

namespace Musique;

use Exception;

class DeqarRestClient
{
    public function request(string $method, array $params = [], int $timeout = 10)
    {
        if ( ! function_exists('acf')) {
            throw new Exception('ACF plugin is required.');
        }

        $apiEndpoint = 'https://backend.deqar.eu/webapi/v2/';

        if (get_field('deqar_sandbox_mode', 'options')) {
            $apiEndpoint = 'https://backend.sandbox.deqar.eu/webapi/v2/';
        }

        $apiEndpoint = $apiEndpoint . $method;

        if ( ! empty($params)) {
            $apiEndpoint = $apiEndpoint . '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Content-type: application/json',
                'Authorization: Bearer ' . get_field('deqar_api_key', 'options'),
            ]
        );

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $jsonResponse = json_decode($response, true);

        if ( ! $jsonResponse) {
            throw new Exception("Invalid response.");
        }

        if (strpos($httpStatus, '2') !== 0) {
            throw new Exception($this->flattenError($jsonResponse));
        } else {
            return $jsonResponse;
        }
    }

    public function flattenError($error)
    {
        $message = trim($error['message']);
        $innerMessages = [];

        foreach ($error['innerErrors'] as $innerError) {
            $innerMessages[] = self::flattenError($innerError);
        }

        if ( ! empty($message) && ! empty($innerMessages)) {
            $message .= ": ";
        }

        return $message . implode("; ", array_filter($innerMessages));
    }

}
