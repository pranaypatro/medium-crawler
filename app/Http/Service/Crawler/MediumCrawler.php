<?php


namespace App\Http\Service\Crawler;


use App\Http\Transactor\BlogTransactor;


class MediumCrawler extends Crawler implements MediumCrawlerPattern {


    protected $data = "";

    /**
     * This function will be the Single Point which will call other stub methods for fetching parameters by using Regex.
     * It will work on the Blog Overview Page. (Fetch all Titles and links from the overview page)
     * @param $tag
     * @param int $count
     * @return array
     */
    public function fetchBlogsFromTagOverview($tag, int $count = 1) {
        $curlResponse = $this->parseUrl(sprintf(self::LOAD_MORE_URL, $tag, $count*10), self::REQUEST_TYPE_JSON);
        $this->data = $curlResponse['file'];
        $returnArray = $this->fetchTitleAndLinkFromOverview();
        $returnArray['curl_time'] = $curlResponse['meta']['total_time'];
        return $returnArray;
    }

    /**
     * This method delegates the parsing of url and and returns all the matched pattern with the crawled website data.
     * Also returns meta info about the cURL request like total_time for crawling!
     * After extracting data it calls BlogTransactor to store the crawled Information into the database for faster
     * retrieval of data next time.
     * @param $slug
     * @return array
     */
    public function fetchBlogDetailFromLink($slug) {

        // Crawls The url and fetches the data of webpage
        $curlResponse = $this->parseUrl(join('', [self::MEDIUM_ROOT_URL, $slug]), self::REQUEST_TYPE_JSON);


        $this->data = $curlResponse['file'];

        // Matching pattern with the crawled data to extract business data.
        $fetchedData = [
            "title_slug" => $slug,
            "title" => $this->dataExtractor(self::DETAIL_TITLE)[0],
            "creator" => $this->dataExtractor(self::DETAIL_CREATOR)[0],
            "read_time" => $this->dataExtractor(self::DETAIL_READ_TIME)[0],
            "published_at" => $this->dataExtractor(self::DETAIL_PUBLISHED_AT)[0],
            "data" => json_encode($this->dataExtractor(self::DETAIL_DATA)),
            "tags" => $this->dataExtractor(self::DETAIL_TAG),
            "curl_time" => $curlResponse['meta']['total_time']
        ];

        // Saves the Blog Information into database for faster retrieval of data next time.
        BlogTransactor::createBlog($slug, $fetchedData['title'], $fetchedData['creator'], $fetchedData['data'],
            $fetchedData['tags'], $fetchedData['read_time'], $fetchedData['published_at']);

        // returning result.
        return $fetchedData;
    }

    /**
     * Extracts The Title and slug from the crawled Data of Overview Page.
     * and returns the last 10 title and slug if count is more than 9.
     * else returns all the element as it is already less than 10.
     * @return array
     */
    private function fetchTitleAndLinkFromOverview() {
        preg_match_all(self::TITLE_LINK_OVERVIEW,
            $this->data,
            $out, PREG_PATTERN_ORDER);

        if( sizeof($out[1] ) >= 10 ) {
            $out[1] = array_slice($out[1], -10);
            $out[2] = array_slice($out[2], -10);
        }
        $returnArray = [
            "title" => $out[1],
            "url" => $out[2]
        ];
        return $returnArray;
    }

    /**
     * Takes a patterns and match the class variable $data's data for the given pattern.
     * and returns the output[1] (as output[1] contains the extracted string group.)
     * @param string $pattern
     * @return mixed
     */
    private function dataExtractor(string $pattern) {
        preg_match_all($pattern,
            $this->data,
            $out
        );

        return $out[1];
    }

}
