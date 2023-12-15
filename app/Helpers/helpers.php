<?php

use Illuminate\Support\Facades\Http;

function sendMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendMessage?" . http_build_query($data));
}

function deleteMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/deleteMessage?" . http_build_query($data));
}

function editMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/editMessageText?" . http_build_query($data));
}

function createMessageData($c, $t, $k = null)
{
    return [
        'chat_id' => $c,
        'text' => $t,
        'reply_markup' => $k
    ];
}

function createDeleteMessageData(int $c,int $m)
{
    return [
        'chat_id' => $c,
        'message_id' => $m
    ];
}

function createEditMessageData(int $c, int $m, string $t)
{
    return [
        'chat_id' => $c,
        'message_id' => $m,
        'text' => $t
    ];
}
