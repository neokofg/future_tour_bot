<?php

namespace App\Http\Controllers;

use App\Services\BotService;
use App\Services\CallbackService;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function __construct(private BotService $botService, private CallbackService $callbackService)
    {

    }

    public function init(Request $request)
    {
        try {
            $args = json_decode($request->getContent(), true);
            if(isset($args['message'])){
                $args = $args['message'];
                $u = $this->botService->authUser($args);
                $this->botService->fetchMessage($args, $u);
                return response(true, 200);
            } else if (isset($args['callback_query'])) {
                $args = $args['callback_query'];
                $u = $this->callbackService->authUser($args);
                $this->callbackService->fetchCallback($args, $u);
                return response(true, 200);
            } else {
                return $args;
            }
        } catch (\Throwable $e) {
            return response($e, 422);
        }
    }
}
