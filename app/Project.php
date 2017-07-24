<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function product()
	{
		return $this->belongsTo('App\Product', 'product_id', 'id');
	}

	public function contents()
	{
		return $this->hasMany('App\ProjectContent');
	}
}
