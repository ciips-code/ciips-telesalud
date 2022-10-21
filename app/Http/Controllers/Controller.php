<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data = [], $message = '', $status = 200) {
        return response()->json([
            'success'  => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function error($status = 400, $message = '',$data = []) {
        return response()->json([
            'success'  => false,
            'message' => ($message ? : ''),
            'data' => $data,
        ], $status);
    }
}
