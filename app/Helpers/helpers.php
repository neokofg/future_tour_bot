<?php

use Illuminate\Support\Facades\Http;

function sendMessage($data)
{
    Http::get("https://api.telegram.org/bot5716304295:AAHVDPCzodAQOwQU5G-7kLfRUU7AVa2VTRg/sendMessage?" . http_build_query($data));
}
