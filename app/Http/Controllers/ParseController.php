<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\BlogQuery;
use App\Http\Service\Crawler\MediumCrawler;
use Illuminate\Http\Request;


class ParseController extends Controller
{

    private $data;
    private MediumCrawler $mediumCrawler;
    const OVERVIEW_PAGE = "https://medium.com/hackernoon/tagged/%s";
//    const BASE_URL = "https://medium.com/hackernoon/load-more?sortBy=tagged&tagSlug=%s";
//    const MAIN_BLOG_URL = "https://medium.com/hackernoon/load-more?sortBy=tagged&tagSlug=%s";


    /**
     * ParseController constructor.
     */
    public function __construct() {
        $this->mediumCrawler = new MediumCrawler();
    }

    public function parseMediumOverview(Request $request) {
        $this->data = $this->mediumCrawler->fetchBlogsFromTagOverview($request->input('keyword'), $request->input('next'));
        $this->data['next'] = $request->input('next')+1;
        return response()->json(json_encode($this->data));
    }

    public function parseBlog(string $slug, Request $request) {
//        $slug = "chatbots-to-the-rescue-boring-forms-beware-1867d0498c0c";
        $fetchedData = null;
        if( Blog::where('title_slug', '=', $slug)->exists() ) {
            $fetchedData = BlogQuery::getBlog($slug);
            $fetchedData['fetched_from'] = "Database";
            $fetchedData['curl_time'] = "0";
        } else {
            $fetchedData = $this->mediumCrawler->fetchBlogDetailFromLink($slug);
            $fetchedData['fetched_from'] = "Crawler";
        }
        return view('blog-detail')->with('data', $fetchedData);
    }

}
