<?php
namespace App\Repositories;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;

class UserRepository
{
    public function userLogin($credentials, $remember)
    {
        $user = Sentinel::authenticate($credentials, $remember);
        if ($user) {
            $user->last_login = now();
            $user->save();
        }
        return $user;
    }
}
