<?php


namespace App\Http;


use App\Blog;
use App\BlogTagMapping;
use App\Tag;

class BlogQuery {

    public static function getBlog($slug) {
        $blog = Blog::select('id', 'title_slug', 'title', 'data', 'creator')
                ->where('title_slug', '=', $slug)
                ->get()
                ->toArray()[0];
        $tagData = BlogTagMapping::select('tag_name')
                ->where('blog_tag_mapping.blog_id', '=', $blog['id'])
                ->join('tags', 'blog_tag_mapping.tag_id', '=', 'tags.id')
                ->get()->pluck('tag_name')->toArray();
        $blog['tags'] = $tagData;


        return $blog;
    }

}
