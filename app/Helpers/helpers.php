<?php

use Illuminate\Support\Facades\Http;

function sendMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendMessage?" . http_build_query($data))['result']['message_id'];
}

function deleteMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/deleteMessage?" . http_build_query($data));
}

function editMessage($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/editMessageText?" . http_build_query($data));
}

function editOrSendMessage($u, $t, $k = null)
{
    if(isset($u->bot_messageid)) {
        editMessage(createEditMessageData($u->chatid, $u->bot_messageid, $t, $k));
    } else {
        $r = sendMessage(createMessageData($u->chatid, $t, $k));
        $u->bot_messageid = $r;
        $u->save();
    }
}

function getFilePath($f)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/getFile?file_id=". $f)['result']['file_path'];
}

function getFile($f_p)
{
    return Http::get("https://api.telegram.org/file/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/". $f_p);
}

function answerCallback($c)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/answerCallbackQuery?callback_query_id=". $c);
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

function createEditMessageData(int $c, int $m, string $t, $k = null)
{
    return [
        'chat_id' => $c,
        'message_id' => $m,
        'text' => $t,
        'reply_markup' => $k
    ];
}
function answerToBoolean(string $a): bool
{
    return match ($a) {
        'yes' => true,
        'no' => false,
    };
}
