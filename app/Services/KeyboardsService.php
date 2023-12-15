<?php

namespace App\Services;

class KeyboardsService {

    public function started(): string
    {
        return '{
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
    }

    public function aboutUs(): string
    {
        return '{
                 "inline_keyboard": [[
                    {
                        "text": "Отзывы",
                        "url": "https://testReviews.com"
                    },
                    {
                        "text": "Группа",
                        "url": "https://testGroup.com"
                    }]
                ]
            }';
    }
}
