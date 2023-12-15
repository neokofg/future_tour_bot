<?php

namespace App\Services;

use App\Models\User;

class CallbackService {

    public function __construct(private KeyboardsService $keyboardsService)
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
        return $u;
    }

    public function fetchCallback($args, $u)
    {
        if($args['data'] == 1) {
            $this->createForm($u);
        } else if($args['data'] == 2) {
            $text = 'Future© делится успехами';
            $data = createMessageData($args['message']['chat']['id'],$text,$this->keyboardsService->aboutUs());
            sendMessage($data);
        }
    }

    private function createForm($u)
    {
        $text = 'Привет,'."\n".'мы подготовили вопросы, которые помогут понять'."\n".'какие страны подходят тебе';
        sendMessage(createMessageData($u->chatid,$text));

        $u->status = "formStarted";
        $u->save();

        $text = 'Как можно к вам обращаться?';
        sendMessage(createMessageData($u->chatid,$text));
    }
}
