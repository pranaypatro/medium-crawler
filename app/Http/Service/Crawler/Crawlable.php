<?php


namespace App\Http\Service\Crawler;


interface Crawlable {


    const REQUEST_TYPE_JSON = 0;
    const REQUEST_TYPE_HTML = 1;


    const JSON_HEADER_PRESET = [
        'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36',
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    const USER_AGENT_HEADER_PRESET = [
        'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36',
    ];

}
