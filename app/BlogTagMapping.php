<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTagMapping extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'blog_tag_mapping';
    protected $fillable = ['f_blog_id', 'f_tag_id'];
}
