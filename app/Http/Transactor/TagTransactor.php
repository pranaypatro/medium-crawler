<?php


namespace App\Http\Transactor;



use App\Tag;
use Illuminate\Support\Facades\DB;

class TagTransactor {

    public static function createTag(array $tags) {
        $idArray = array();
        try {
            DB::transaction(function () use ($tags, &$idArray) {
                foreach ($tags as $tag) {
                    $idObj = Tag::where('tag_name', '=', $tag)->get('id')->first();

                    if( $idObj == null ) {
                        $tagObj = new Tag;
                        $tagObj->tag_name = $tag;
                        $tagObj->save();
                        array_push($idArray, $tagObj->id);
                    } else {
                        array_push($idArray, $idObj->id);
                    }
                }
            });
        } catch(\Exception $ex) {
            dd("Exception Occurred : " . $ex->getMessage());
        }

        return $idArray;
    }

}
