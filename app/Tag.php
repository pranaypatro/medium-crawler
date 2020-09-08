<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tags';
    protected $fillable = ['id', 'tag_name'];

}
