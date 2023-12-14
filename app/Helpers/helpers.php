<?php

use Illuminate\Support\Facades\Http;

function sendMessage($data)
{
    Http::get("https://api.telegram.org/bot6739120381:AAGTQuyHKVkjaZS727EYElZbaWQQ6_DS-5E/sendMessage?" . http_build_query($data));
}
