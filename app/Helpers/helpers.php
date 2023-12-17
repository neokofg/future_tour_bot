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

function editForTimeMessage($c, $m, $t1, $t2, $k = null)
{
    $data = [
        "chat_id" => $c,
        "message_id" => $m,
        "text" => $t1
    ];
    $newData = [
        "chat_id" => $c,
        "message_id" => $m,
        "text" => $t2,
        "reply_markup" => $k
    ];
    $response1 = Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/editMessageText?" . http_build_query($data));
    $response1->throw();
    sleep(1);
    $response2 = Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/editMessageText?" . http_build_query($newData));
    $response2->throw();
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

function sendVideo($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendVideo?" . http_build_query($data));
}

function sendPhoto($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendPhoto?" . http_build_query($data));
}

function sendMediaGroup($data)
{
    return Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendMediaGroup?" . http_build_query($data));
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

function createVideoMessageData(int $c, string $u)
{
    return [
        'chat_id' => $c,
        'video' => $u,
    ];
}

function createPhotoMessageData(int $c, string $u)
{
    return [
        'chat_id' => $c,
        'photo' => $u,
    ];
}


function answerToBoolean(string $a): bool
{
    return match ($a) {
        'yes' => true,
        'no' => false,
    };
}

function booleanToAnswer(bool $b): string
{
    return match ($b) {
        true => 'ДА',
        false => 'НЕТ',
    };
}

function createMediaGroupData(int $c,array $medias)
{
    $mediaArray = [];
    foreach($medias as $media) {
        $mediaArray[] = [
            "type" => $media['type'],
            "media" => $media['url']
        ];
    }
    return [
        'chat_id' => $c,
        'media' => json_encode($mediaArray)
    ];
}
