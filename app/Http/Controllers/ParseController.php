<?php

namespace App\Http\Controllers;

use App\Http\Service\Crawler\MediumCrawler;
use Illuminate\Http\Request;


class ParseController extends Controller
{

    private $data;
    private MediumCrawler $mediumCrawler;
    const OVERVIEW_PAGE = "https://medium.com/hackernoon/tagged/%s";
    const BASE_URL = "https://medium.com/hackernoon/load-more?sortBy=tagged&tagSlug=%s";
    const MAIN_BLOG_URL = "https://medium.com/hackernoon/load-more?sortBy=tagged&tagSlug=%s";


    /**
     * ParseController constructor.
     */
    public function __construct() {
        $this->mediumCrawler = new MediumCrawler();
    }

    public function parseMediumOverview(Request $request) {

        $this->data = $this->mediumCrawler->fetchBlogsFromTagOverview($request->input('keyword'));

        return response()->json(json_encode($this->data));
    }

    public function parseMediumOverviewNext() {

    }


    public function parseMainBlog(Request $request) {
        $tag = $request->input('keyword');
//        $this->data = $this->mediumCrawler->parseUrl("https://medium.com/hackernoon/tachyon-next-generation-tcp-ip-with-blockchain-7b2da1c04112?source=---------1-----------------------");

        $this->data = $this->mediumCrawler->parseUrl("https://medium.com/hackernoon/the-future-of-cyber-security-in-the-fintech-era-78b9d7f7c0f0");
//        dump($this->data);

        $fetchedData = [
            "title" => $this->fetchTitle(),
            "creator" => $this->fetchCreator(),
            "detail" => $this->fetchDetail(),
            "tags" => implode(', ', $this->fetchTags())
        ];

        return view('blog-detail')->with('data', $fetchedData);
    }







    public function fetchTitle() {
        preg_match('|class="fo fp fq fr b fs ft fu fv fw fx fy fz ga gb gc gd ge gf gg gh ec">(.*)</h1>|U',
            $this->data,
            $out
        );
//        dump("Title:-");
        return ($out[1]);
    }

    public function fetchTags() {
        preg_match_all('|<a href="(.*)" class="ce cf cg kk hv sw sx hu r sy">(.*)</a>|U',
            $this->data,
            $out
        );
//        dump("Tags:-");
        return ($out[2]);
    }

    public function fetchCreator() {
        preg_match('|<a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a>|U',
            $this->data,
            $out
        );
//        dump("Creator :-");
        return ($out[2]);
    }

    public function fetchDetail() {
        preg_match('|<div><a class="cl cm at au av aw ax ay az ba he bd ei ej" rel="noopener" href="(.*)">(.*)</a> <!-- -->·<!-- --> <!-- -->(.*)<!-- -->(.*)</div>|U',
            $this->data,
            $out
        );
//        dump("Detail:-");
//        dump($out[2]);
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
