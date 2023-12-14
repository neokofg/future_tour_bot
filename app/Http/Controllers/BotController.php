<?php

namespace App\Http\Controllers;

use App\Services\BotService;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function __construct(private BotService $botService)
    {

    }

    public function init()
    {
        try {
            $args = json_decode(file_get_contents('php://input'), true);
            $args = $args['message'];
            $u = $this->botService->authUser($args);
            $this->botService->getFunction($args, $u);
            return response(true, 200);
        } catch (\Throwable $e) {
            return response($e, 422);
        }
    }
}
