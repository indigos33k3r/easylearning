<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clipart extends Model
{
	protected $fillable = [
		'image_path', 'file_name'
    ];
}
