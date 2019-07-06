<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //
    protected $fillable = [
    	'title', 'img', 'short_description', 'description', 'user_id'
    ];
    public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function comments(){
    	return $this->hasMany('App\Comment');
    }
    public function favorites(){
    	return $this->hasMany('App\Favorite', 'recipe_id');
    }
}
