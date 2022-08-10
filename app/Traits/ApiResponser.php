<?php

namespace App\Traits;

trait ApiResponser
{
    protected function errorResponse($code, $msg, $status)
    {
        $response = [
            'status' => 'failed',
            'code' => $code,
            'message' => trans($msg),
        ];
        return response()->json($response, $status);
    }

    protected function successResponse($code, $msg, $status, $data = [])
    {
        $response = [
            'status' => 'success',
            'code' => $code,
            'message' => trans($msg),
            'data' =>  $data,
        ];
        return response()->json($response, $status);
    }
}
