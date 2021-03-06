<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'blogs';
    protected $fillable = ['title_slug', 'title', 'creator', 'data', 'read_time', 'published_at'];

}
