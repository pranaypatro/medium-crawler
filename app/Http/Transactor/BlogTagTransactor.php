<?php


namespace App\Http\Transactor;


use App\BlogTagMapping;
use Illuminate\Support\Facades\DB;

class BlogTagTransactor {

    /**
     * Creates a mapping table entry for a blog with its affiliated Tags.
     * @param int $blogId
     * @param $tagIds
     */
    public static function createMappingEntry(int $blogId, $tagIds) {
        try {
            DB::transaction(function () use ($blogId, $tagIds) {
                foreach ($tagIds as $tagId) {
                    $btm = new BlogTagMapping();
                    $btm->blog_id = $blogId;
                    $btm->tag_id = $tagId;
                    $btm->save();
                }
            });
        } catch (\Exception $ex) {
            dd("Exception Occurred while inserting blog_tag_mapping entry : " . $ex->getMessage() );
        }
    }
}
