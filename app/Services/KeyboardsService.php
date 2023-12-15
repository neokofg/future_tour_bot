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

    public function answer(): string
    {
        return '{
                 "inline_keyboard": [[
                    {
                        "text": "Да",
                        "callback_data": "yes"
                    },
                    {
                        "text": "Нет",
                        "callback_data": "no"
                    }]
                ]
            }';
    }

    public function portfolio(): string
    {
        return '{
                 "inline_keyboard": [[
                    {
                        "text": "Заполнила",
                        "callback_data": "3"
                    },
                    {
                        "text": "Пример видео",
                        "callback_data": "4"
                    }]
                ]
            }';
    }

    public function memo(): string
    {
        return '{
                 "inline_keyboard": [[
                    {
                        "text": "Памятка",
                        "callback_data": "5"
                    }]
                ]
            }';
    }
}
