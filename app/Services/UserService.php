<?php


namespace App\Services;


use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Store new user.
     *
     * @return \App\User $user
     */
    public function store($data)
    {
        return $this->userRepository->store($data);
    }

    /**
     * Get specific user details.
     *
     * @return \App\User $user
     */
    public function getUser($field,$value)
    {
        return $this->userRepository->getUser($field,$value);
    }

    /**
     * Follow user.
     *
     * @return \App\User $user
     */
    public function follow($userId,$followingId)
    {
        return $this->userRepository->follow($userId,$followingId);
    }

    /**
     * Followers list.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following($userId)
    {
        return $this->userRepository->following($userId);
    }

    /**
     * Auth response.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authResponse($user)
    {
        $accessToken = $user->createToken("tweet")->plainTextToken;
        $data['user'] = new UserResource($user);
        $data['access_token'] = $accessToken;
        return $data;
    }
}
