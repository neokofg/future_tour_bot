<?php

use Illuminate\Support\Facades\Http;

function sendMessage($data)
{
    Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendMessage?" . http_build_query($data));
}

function createMessageData($c, $t, $k = null)
{
    return [
        'chat_id' => $c,
        'text' => $t,
        'reply_markup' => $k
    ];
}
