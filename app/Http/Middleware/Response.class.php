<?php

namespace App\Http\Middleware\Response;

class Response
{
    public static function success($response = [], $message = "success", $code = 200)
    {
        $response = array(
            'status' => true,
            'response' => $response,
            'message' => $message
        );
        http_response_code($code);
        echo json_encode($response);
    }

    public static function error($errMessage = "", $code = "")
    {
        $response = array(
            'status' => false,
            'message' => $errMessage
        );
        http_response_code($code);
        echo json_encode($response);
    }
}