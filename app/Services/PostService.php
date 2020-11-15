<?php


namespace App\Services;


use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Store new post.
     *
     * @return \App\Post $post
     */
    public function store($data){
        return $this->postRepository->store($data);
    }

    /**
     * Get all posts.
     *
     * @return \App\Post $post
     */
    public function list($data = null){
        return $this->postRepository->list($data);
    }

}
