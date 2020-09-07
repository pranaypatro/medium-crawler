<?php


namespace App\Http\Query;


use App\Blog;
use App\BlogTagMapping;

class BlogQuery {

    /**
     * This method fetches Blog Information and all The tags that belong to that particular blog.
     * @param $slug
     * @return mixed
     */
    public static function getBlog($slug) {
        $blogDetails = Blog::select('id', 'title_slug', 'title', 'data', 'creator')
                ->where('title_slug', '=', $slug)
                ->get()
                ->toArray()[0];
        $tagData = BlogTagMapping::select('tag_name')
                ->where('blog_tag_mapping.blog_id', '=', $blogDetails['id'])
                ->join('tags', 'blog_tag_mapping.tag_id', '=', 'tags.id')
                ->get()->pluck('tag_name')->toArray();
        $blogDetails['tags'] = $tagData;
        return $blogDetails;
    }

}
