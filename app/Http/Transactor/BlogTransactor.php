<?php


namespace App\Http\Transactor;


use App\Blog;
use Illuminate\Support\Facades\DB;

class BlogTransactor {

    /**
     * This method will create an entry for the Blog in Blog table and call TagTransactor to insert unique Tags, and
     * calls BlogTagTransactor to create mapping Entry for the same.
     * @param string $titleSlug
     * @param $title
     * @param $creator
     * @param $data
     * @param $tags
     * @param $readTime
     * @param $publishedAt
     */
    public static function createBlog(string $titleSlug, $title, $creator, $data, $tags, $readTime, $publishedAt) {
        try {
            DB::transaction(function () use ($publishedAt, $readTime, $tags, $titleSlug, $title, $creator, $data) {

                $blog = new Blog;
                if( !Blog::where('title_slug', '=', $titleSlug)->exists() ) {
                    $blog->title_slug = $titleSlug;
                    $blog->title = $title;
                    $blog->creator = $creator;
                    $blog->read_time = $readTime;
                    $blog->published_at = $publishedAt;
                    $blog->data = json_encode($data);
                    $blog->save();
                }
                $tagIds = TagTransactor::createTag($tags);
                BlogTagTransactor::createMappingEntry($blog->id, $tagIds);
            });
        } catch(\Exception $ex) {
            dd("Exception Occurred in BlogTransactor : " . $ex->getMessage() );
        }
    }
}
