<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        // create new user
        $user = $this->userService->store($request->validated());
        // create user's access token
        $data = $this->userService->authResponse($user);
        return response()->json(['data' => $data],Response::HTTP_CREATED);

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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            // generate access token for user
            $user = $this->userService->getUser('email',$request->email);
            $data = $this->userService->authResponse($user);
            return response()->json(['data' => $data],Response::HTTP_OK);
        }
        return response()->json(responseFormat(__('messages.incorrect_email_or_password')),Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [array] msg
     */
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(responseFormat(__('messages.logout_successfully')), Response::HTTP_OK);
    }
}
