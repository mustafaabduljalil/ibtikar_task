<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['tweet_text','user_id'];

    /**
     * Get user (owner) of post
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
