<?php

namespace App\Http\Controllers;

use App\Enum\config;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\User\FollowRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService,$postService;

    public function __construct(UserService $userService,PostService $postService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
    }

    /**
     * Store a newly following.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object
     */
    public function follow(FollowRequest $request)
    {
        $validated = $request->validated();
        $this->userService->follow($request->user()->id,$validated['following_id']);
        return response()->json(HelperController::responseFormat(__('messages.followed_successfully')), 200);

    }

    /**
     * Time line of user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object
     */
    public function timeline(Request $request)
    {
       return PostResource::collection($this->postService->list($this->userService->following($request->user()->id)->pluck('user_id')));
    }
}
