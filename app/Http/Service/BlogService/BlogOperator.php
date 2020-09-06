<?php


namespace App\Http\Service\BlogService;


use App\Blog;
use App\BlogTagMapping;
use App\Http\Service\BlogTagOperator;
use Illuminate\Support\Facades\DB;

class BlogOperator {
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
                $tagIds = TagOperator::createTag($tags);
                BlogTagOperator::createMappingEntry($blog->id, $tagIds);
            });
        } catch(\Exception $ex) {
            dd("Exception Occurred : " . $ex->getMessage() );
        }
    }
}
