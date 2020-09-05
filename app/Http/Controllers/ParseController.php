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

    public function parseBlog() {
        $url = "https://medium.com/hackernoon/choosing-the-right-platform-for-chatbot-development-ux-ui-perspective-ee44694e37a2";

        $fetchedData = $this->mediumCrawler->fetchBlogDetailFromLink($url);
//        dd($fetchedData);
        return view('blog-detail')->with('data', $fetchedData);
    }





}
