<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Regitser
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [file] image
     * @param  [string] password
     * @return [array] user data
     * @throws \SMartins\PassportMultiauth\Exceptions\MissingConfigException
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        // hash user's password
        $validated['password'] = bcrypt($validated['password']);
        // store image
        $validated['image'] = HelperController::uploadImage($validated['image'],'users');
        // create new user
        $user = $this->userService->store($validated);
        // create user's access token
        $accessToken = $user->createToken("tweet")->plainTextToken;
        $data['user'] = new UserResource($user);
        $data['access_token'] = $accessToken;;
        return response()->json(['data' => $data],201);

    }

    /**
     * Login
     *
     * @param  [string] email
     * @param  [string] password
     * @return [array] user data
     * @throws \SMartins\PassportMultiauth\Exceptions\MissingConfigException
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])){
            // generate access token for user
            $user = $this->userService->getUser('email',$validated['email']);
            $accessToken = $user->createToken("tweet")->plainTextToken;
            $data['user'] = new UserResource($user);
            $data['access_token'] = $accessToken;;
            return response()->json(['data' => $data],200);
        }

        return response()->json(HelperController::responseFormat(__('messages.incorrect_email_or_password')),401);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [array] msg
     */
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(HelperController::responseFormat(__('messages.logout_successfully')), 200);
    }
}
