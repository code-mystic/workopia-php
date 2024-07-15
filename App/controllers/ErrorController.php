<?php

namespace App\controllers;

class ErrorController
{

    public static function notFoundError($message = 'The requested resource is not found')
    {

        http_response_code(404);

        loadView('error', [
            'code' => '404',
            'message' => $message
        ]);
    }

    public static function notAuthorised($message = 'You are not authorised to view this resource')
    {

        http_response_code(403);

        loadView('error', [
            'code' => '403',
            'message' => $message
        ]);
    }
}
