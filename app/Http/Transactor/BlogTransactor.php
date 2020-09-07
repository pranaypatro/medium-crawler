<?php


namespace App\Http\Transactor;


use App\Blog;
use Illuminate\Support\Facades\DB;

class BlogTransactor {
    public static function createBlog(string $titleSlug, $title, $creator, $data, $tags) {
        try {
            DB::transaction(function () use ($tags, $titleSlug, $title, $creator, $data) {
                $blog = new Blog;
                if( !Blog::where('title_slug', '=', $titleSlug)->exists() ) {
                    $blog->title_slug = $titleSlug;
                    $blog->title = $title;
                    $blog->creator = $creator;
                    $blog->data = $data;
                    $blog->save();
                }
                $tagIds = TagTransactor::createTag($tags);
                BlogTagTransactor::createMappingEntry($blog->id, $tagIds);
            });
        } catch(\Exception $ex) {
            dd("Exception Occurred : " . $ex->getMessage() );
        }
    }
}
