<?php


namespace App\Http\Service\Crawler;


use App\Http\Service\BlogService\BlogOperator;
use App\Http\Service\BlogService\TagOperator;

class MediumCrawler extends Crawler implements Crawlable {

    const MEDIUM_ROOT_URL = "https://medium.com/hackernoon/";
    const LOAD_MORE_URL = self::MEDIUM_ROOT_URL . "load-more?sortBy=tagged&tagSlug=%s&limit=%s";
    protected $data = "";

    public function __construct() {}

    /**
     * This function will be the Single Point which will call other stub methods for fetching parameters by using Regex.
     * It will work on the Blog Overview Page. (Fetch all Titles and links from the overview page)
     * @param $tag
     * @param int $count
     * @return array
     */
    public function fetchBlogsFromTagOverview($tag, int $count = 10) {
        $this->data = $this->parseJsonUrl(sprintf(self::LOAD_MORE_URL, $tag, $count));
        return $this->fetchTitleAndLinkFromOverview();
    }

    /**
     * @param $slug
     * @return array
     */
    public function fetchBlogDetailFromLink($slug) {

        $this->data = $this->parseJsonUrl(join('', [self::MEDIUM_ROOT_URL, $slug]));
        $fetchedData = [
            "title_slug" => $slug,
            "title" => $this->fetchTitle(),
            "creator" => $this->fetchCreator(),
//            "detail" => $this->fetchDetail(),
            "tags" => $this->fetchTags()
        ];

        BlogOperator::createBlog($slug, $fetchedData['title'], $fetchedData['creator'], "dummy data", $fetchedData['tags']);
        return $fetchedData;
    }

    /**
     * Extracts The Title and Link from the crawled Data of Overview Page.
     * @return array
     */
    private function fetchTitleAndLinkFromOverview() {
        preg_match_all('|{"id":".*","versionId":".*","creatorId":".*","homeCollectionId":".*","title":"(.*)","detectedLanguage":".*","latestVersion":".*","latestPublishedVersion":".*","hasUnpublishedEdits.*"uniqueSlug":"(.*),"|U',
            $this->data,
            $out, PREG_PATTERN_ORDER);

//        $prefixed_array = preg_filter('/^/', self::MEDIUM_ROOT_URL, $out[2]);

        $returnArray = [
            "title" => $out[1],
            "url" => $out[2]
        ];
        return $returnArray;
    }

    private function fetchTitle() {
//        preg_match('|class="fo fp fq fr b fs ft fu fv fw fx fy fz ga gb gc gd ge gf gg gh ec">(.*)</h1>|U',
//            $this->data,
//            $out
//        );

        preg_match('|{"success":[a-zA-Z]*,"payload":{"value":{"id":".*","versionId":".*","creatorId":".*","homeCollectionId":"[a-zA-Z0-9]*","title":"(.*)","detectedLanguage":"en"|U',
            $this->data,
            $out
        );
        return ($out[1]);
    }

    private function fetchTags() {
//        preg_match_all('|<a href="(.*)" class="ce cf cg kk hv sw sx hu r sy">(.*)</a>|U',
//            $this->data,
//            $out
//        );

        preg_match_all('|{"slug":"[A-Za-z0-9]*","name":"([A-Za-z0-9]*)","postCount":[0-9]*,"metadata":{"postCount":[0-9]*,"coverImage":.*},"type":"Tag"}|mU',
            $this->data,
            $out
        );
        return ($out[1]);
    }

    private function fetchCreator() {
//        preg_match('|<a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a>|U',
//            $this->data,
//            $out
//        );

        preg_match('|"User":.*"name":"(.*)","username"|U',
            $this->data,
            $out
        );
        return ($out[1]);
    }

    private function fetchDetail() {
        preg_match('|<div><a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a> <!-- -->·<!-- --> <!-- -->(.*)<!-- -->(.*)</div>|U',
            $this->data,
            $out
        );
        return $out[2] . ', ' . $out[3] . $out[4];
    }

    public function fetchResponses() {
        preg_match('|class="fo fp fq fr b fs ft fu fv fw fx fy fz ga gb gc gd ge gf gg gh ec">(.*)</h1>|U',
            $this->data,
            $out
        );
        dump($out);
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
