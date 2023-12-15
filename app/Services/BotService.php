<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class BotService {

    public function __construct(private KeyboardsService $keyboardsService, private FormService $formService)
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

    public function fetchMessage($args, $u)
    {
        switch ($u->status) {
            case 'started':
                $this->started($u);
                break;
            case Str::startsWith($u->status, 'form'):
                $this->formService->fetchForm($args, $u);
                break;
        }
    }

    private function started($u)
    {
        $text = 'Дамы '. PHP_EOL .'Вас приветствует Future© '. PHP_EOL .' - Чтобы зарабатывать деньги в турах, '. PHP_EOL .'
    • необходимо заполнить анкету '. PHP_EOL .'
    • узнать о нас';
        sendMessage(createMessageData($u->chatid, $text, $this->keyboardsService->started()));
    }
}
