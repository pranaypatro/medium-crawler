<?php


namespace App\Http\Service\Crawler;


class Crawler implements Crawlable {

    public function parseUrl(string $url, int $requestType) {

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $url);

        if($requestType == self::REQUEST_TYPE_JSON) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, self::JSON_HEADER_PRESET);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, self::USER_AGENT_HEADER_PRESET);
        }

        $file = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        file_put_contents('crawl_output.txt', $file);
        $returnData['file'] = $file;
        $returnData['meta'] = $info;
        return $returnData;

    }



}
