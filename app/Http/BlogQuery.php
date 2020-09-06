<?php


namespace App\Http;


use App\Blog;

class BlogQuery {

    public static function getBlog($slug) {
        return Blog::select('title_slug', 'title', 'data', 'creator')->where('title_slug', '=', $slug)->get()->toArray()[0];
    }

}
