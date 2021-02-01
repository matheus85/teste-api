<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendOk($message = null, $data = null)
    {
        $response = [
            'message' => $message,
            'data'    => $data
        ];

        return response()->json($response, 200);
    }

    public function sendError($message = null, $errors = null, $data = null, $code = 400)
    {
        $response = [
            'message' => $message,
            'errors'  => $errors,
            'data'    => $data
        ];

        return response()->json($response, $code);
    }
}
