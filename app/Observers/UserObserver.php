<?php

namespace App\Observers;

use App\Http\Controllers\HelperController;
use App\Services\UploadImageService;
use App\User;

class UserObserver
{
    /**
     * Handle the user "saving" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saving(User $user){
        $user->password = bcrypt($user->password);
        $user->image = UploadImageService::upload(request()->image,'users');
    }
}
