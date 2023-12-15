<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class CallbackService {

    public function __construct(private KeyboardsService $keyboardsService,private FormService $formService)
    {

    }

    public function authUser($args): User
    {
        $u = User::where("id", "=", $args['from']['id'])->first();
        if(!$u){
            $u = new User();
            $u->id = $args['from']['id'];
            $u->chatid = $args['chat']['id'];
            $u->first_name = $args['from']['first_name'] ?? null;
            $u->last_name = $args['from']['last_name'] ?? null;
            $u->username = $args['from']['username'];
            $u->language_code = $args['from']['language_code'];
            $u->save();
        }
        return $u->fresh();
    }

    public function fetchCallback($args, $u)
    {
        if(Str::startsWith($u->status, 'form')) {
            $this->formService->fetchForm($args, $u);
        }
        if($args['data'] == 1) {
            $this->createForm($u);
        } else if($args['data'] == 2) {
            $text = 'Future© делится успехами';
            $data = createMessageData($u->chatid,$text,$this->keyboardsService->aboutUs());
            sendMessage($data);
        } else if($args['data'] == 3) {

        } else if($args['data'] == 4) {
            $text = 'на что нужно обратить внимание:'. "\n" . '     - полный рост'. "\n" . '     - короткое нижнее белье'. "\n" . '     - белое освещение'. "\n" . '     - хорошее качество';
            $data = createMessageData($u->chatid,$text);
            sendMessage($data);
        }
    }

    private function createForm($u)
    {
        $text = 'Привет,'."\n".'мы подготовили вопросы, которые помогут понять'."\n".'какие страны подходят тебе';
        sendMessage(createMessageData($u->chatid,$text));

        $text = 'Как можно к вам обращаться?';
        $response = sendMessage(createMessageData($u->chatid,$text));

        $u->bot_messageid = $response;
        $u->status = "formStarted";
        $u->save();
    }
}
