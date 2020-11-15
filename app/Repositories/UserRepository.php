<?php


namespace App\Repositories;

use App\Enum\config;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Store new user.
     *
     * @return \App\User $user
     */
    public function store($data)
    {
        return $this->user->create($data);
    }

    /**
     * Get specific user.
     *
     * @return \App\User $user
     */
    public function getUser($field,$value)
    {
        return $this->user->where($field,$value)->first();
    }

    /**
     * Follow user.
     *
     * @return array
     */
    public function follow($userId,$followingId)
    {
        return $this->getUser('id',$userId)->following()->sync($followingId);
    }

    /**
     * Followers list.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following($userId)
    {
        return $this->getUser('id',$userId)->following();
    }



}
