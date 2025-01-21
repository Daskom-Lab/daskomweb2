<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        try {
            $response = [
                'success' => true,
                'data'    => $result,
                'message' => $message,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send response.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        try {
            $response = [
                'success' => false,
                'message' => $error,
            ];
            if (!empty($errorMessages)) {
                $response['data'] = $errorMessages;
            }
            return response()->json($response, $code);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send error response.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }    
}
