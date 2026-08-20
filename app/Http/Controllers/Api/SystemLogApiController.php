<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;

class SystemLogApiController extends Controller
{
    public function index()
    {
        return response()->json(
            SystemLog::latest()->get()
        );
    }
}