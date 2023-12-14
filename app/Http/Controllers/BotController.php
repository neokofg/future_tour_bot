<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    public function init()
    {
        try {
            $args = json_decode(file_get_contents('php://input'));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e], 422);
        }
    }
}
