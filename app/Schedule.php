<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	public function getStartAttribute($value)
    {
        return (float)$value;
    }

    public function getEndAttribute($value)
    {
        return (float)$value;
    }
}
