<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    //
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'image_path', 'file_name'
    ];

    public function categories()
    {
    	return $this->belongsToMany('App\CategoryShape', 'category_shape', 'shape_id', 'category_id');
    }

}
