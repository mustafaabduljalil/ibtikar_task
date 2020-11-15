<?php


namespace App\Repositories;

use App\Enum\config;
use App\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get user's posts.
     *
     * @return \App\Post $post
     */
    public function list($data = null)
    {
        return $this->post->when(isset($data['user_id']),function ($query) use ($data){
                                $query->whereIn('user_id',$data['user_id']);
                            })->paginate(config::paginationCount);
    }

    /**
     * Store new post.
     *
     * @return \App\Post $post
     */
    public function store($data)
    {
        return $this->post->create($data);
    }

}
