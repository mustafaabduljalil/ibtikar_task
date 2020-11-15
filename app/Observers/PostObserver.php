<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    /**
     * Handle the post "saving" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function saving(Post $post){
        $post->user_id = request()->user()->id;
    }


}
