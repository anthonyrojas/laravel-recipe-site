<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function recipe(){
    	return $this->belongsTo('App\Recipe');
    }
    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
