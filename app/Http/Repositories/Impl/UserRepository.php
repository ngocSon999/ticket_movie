<?php
namespace App\Http\Repositories\Impl;

use App\Http\Repositories\UserRepoInterface;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Support\Facades\DB;

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

    public function createUser($credentials, $role): bool|UserInterface
    {
        $user = Sentinel::registerAndActivate($credentials);
        $user->roles()->attach(Sentinel::findRoleById($role));

        return $user;
    }

    public function editUser($id)
    {
        return Sentinel::findById($id);
    }
}
