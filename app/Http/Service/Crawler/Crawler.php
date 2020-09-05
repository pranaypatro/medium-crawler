<?php


namespace App\Http\Service\Crawler;


class Crawler {

    public static function parseUrl($url) {

        $customHeaders = [
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36',
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $ch = curl_init();
        $timeout = 5;


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders);

        $file = curl_exec($ch);

        curl_close($ch);

        file_put_contents('crawl_output.txt', $file);
        return $file;
    }

}
