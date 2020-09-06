<?php


namespace App\Http\Service;


use App\BlogTagMapping;
use Illuminate\Support\Facades\DB;

class BlogTagOperator {

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
            dd("Exception Occured while inserting blog_tag_mapping entry : " . $ex->getMessage() );
        }
    }
}
