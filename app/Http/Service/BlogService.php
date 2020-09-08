<?php


namespace App\Http\Service;


use App\Blog;
use App\Http\Query\BlogQuery;
use App\Http\Service\Crawler\MediumCrawler;

class BlogService {

    private MediumCrawler $mediumCrawler;

    /**
     * BlogService constructor.
     */
    public function __construct() {
        $this->mediumCrawler = new MediumCrawler();
    }


    /**
     * This method will check if The blog is already available in our database or not.
     * if available then return that blog or crawl the blog using CrawlerService.
     * TODO: need to handle the scenario where the blog is updated in and it already exists in our database then an
     * old copy of blog will be displayed.
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBlog(string $slug) {
        $fetchedData = null;
        if( Blog::where('title_slug', '=', $slug)->exists() ) {
            $fetchedData = BlogQuery::getBlog($slug);
            $fetchedData['fetched_from'] = "Database";
            $fetchedData['data'] = json_decode($fetchedData['data']);
            $fetchedData['curl_time'] = "0";
        } else {
            $fetchedData = $this->mediumCrawler->fetchBlogDetailFromLink($slug);
            $fetchedData['fetched_from'] = "Crawler";
        }
        return $fetchedData;
    }

    /**
     * This method will fetch all the title for particular tag.
     * and increment the next counter. (for next page request)
     * @param string $keyword for which we need to find the blogs.
     * @param int $next depending on this attribute the title for that page is returned.
     * @return array holds data such as Title, uniqueTitleSlug, nextButtonValue.
     */
    public function getTitles(string $keyword, int $next) {
        $data = $this->mediumCrawler->fetchBlogsFromTagOverview($keyword, $next);
        $data['next'] = $next+1;
        return $data;
    }

}
