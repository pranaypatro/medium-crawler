<?php


namespace App\Http\Transactor;



use App\Tag;
use Illuminate\Support\Facades\DB;

class TagTransactor {

    /**
     * This method will create a new entry for a Tag if it doesnt exists and push all the ids of the tag which are
     * passed to this method (including the newly created tag entry as well as the existing tag entry)
     * This returned arary of tag ids will be used by the BlogTagTransactor to make the Mapping table entry in
     * blog_tag_mapping table in database.
     * @param array $tags
     * @return array
     */
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
