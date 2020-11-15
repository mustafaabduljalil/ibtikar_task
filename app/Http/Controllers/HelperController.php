<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    // upload image function
    public static function uploadImage($image,$dir){
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        \Storage::disk('local')->putFileAs($dir, $image, $imageName);
//        if(!is_null($user->getOriginal()['avatar'])){
//            $image_path = public_path().'/storage/'.$user->getOriginal()['avatar'];
//            unlink($image_path);
//        }
        return $dir.'/'.$imageName;
    }

    // return error msg
    public static function responseFormat($msg){
        $error = new \stdClass();
        $error->message = $msg;
        return $error;
    }
}
