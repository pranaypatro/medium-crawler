<?php


namespace App\Http\Service\Crawler;


use DOMDocument;

class MediumCrawler extends Crawler implements Crawlable {

    const MEDIUM_ROOT_URL = "https://medium.com/hackernoon/";
    const LOAD_MORE_URL = self::MEDIUM_ROOT_URL . "load-more?sortBy=tagged&tagSlug=%s&limit=%s";
    protected $data = "";

    public function __construct() {}

    public function fetchBlogsFromTagOverview($tag, int $count = 10) {
        $this->data = $this->parseUrl(sprintf(self::LOAD_MORE_URL, $tag, $count));
        return $this->fetchTitleAndLinkFromOverview();
    }

    public function fetchTitleAndLinkFromOverview() {
        preg_match_all('|{"id":".*","versionId":".*","creatorId":".*","homeCollectionId":".*","title":"(.*)","detectedLanguage":".*","latestVersion":".*","latestPublishedVersion":".*","hasUnpublishedEdits.*"uniqueSlug":"(.*),"|U',
            $this->data,
            $out, PREG_PATTERN_ORDER);

        $prefixed_array = preg_filter('/^/', self::MEDIUM_ROOT_URL, $out[2]);

        $returnArray = [
            "title" => $out[1],
            "url" => $prefixed_array
        ];
        return $returnArray;
    }

}


/**
 *
 * //        preg_match_all('|<h3.*class=".*graf--title">(.*)<\/h3><p.*class=".*">.*<\/p><\/div><\/div><\/section><\/div><\/a><\/div><div class="postArticle-readMore"><a class=".*"   href="(.*)" data-action=.*>Read more…<\/a>|U',
//            $this->data,
//            $out, PREG_PATTERN_ORDER);
//        dump($out[1]);
//        dump($out[2]);
 */
