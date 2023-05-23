<?php
namespace App\Http\Repositories\Impl;

use App\Http\Repositories\UserRepoInterface;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;

class UserRepository implements UserRepoInterface
{
    public function userLogin($credentials, $remember): UserInterface|bool
    {
        $user = Sentinel::authenticate($credentials, $remember);
        if ($user) {
            $user->last_login = now();
            $user->save();
        }

        return $user;
    }
}
