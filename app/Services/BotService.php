<?php

namespace App\Services;

use App\Models\User;

class BotService {

    public function authUser($args): User
    {
        $u = User::where("userid", "=", $args['from']['id'])->first();
        if(!$u){
            $u = new User();
            $u->userid = $args['from']['id'];
            $u->chatid = $args['chat']['id'];
            $u->first_name = $args['from']['first_name'] ?? null;
            $u->last_name = $args['from']['last_name'] ?? null;
            $u->username = $args['from']['username'];
            $u->language_code = $args['from']['language_code'];
            $u->save();
        }
        return $u;
    }

    public function getFunction($args, $u)
    {
        switch ($u->status) {
            case 'started':
                $this->started($args['chat']['id'],$u);
                break;

        }
    }

    private function started($chat_id, $u)
    {
        $kb =
            '{
                 "inline_keyboard": [[
                    {
                        "text": "Заполнить анкету",
                        "callback_data": "1"
                    },
                    {
                        "text": "О нас",
                        "callback_data": "2"
                    }]
                ]
            }';
        $data = [
            'chat_id' => $chat_id,
            'text' => 'Дамы '. PHP_EOL .'Вас приветствует Future© '. PHP_EOL .' - Чтобы зарабатывать деньги в турах, '. PHP_EOL .'
    • необходимо заполнить анкету '. PHP_EOL .'
    • узнать о нас
            ',
            'reply_markup' => json_encode(json_decode($kb))
        ];
        sendMessage($data);
    }
}
