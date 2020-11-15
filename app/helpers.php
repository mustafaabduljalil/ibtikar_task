<?php


if(!function_exists('responseFormat')){
    // return error msg
    function responseFormat($msg){
        $error = new \stdClass();
        $error->message = $msg;
        return $error;
    }
}
