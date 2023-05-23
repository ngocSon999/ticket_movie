<?php

namespace App\Http\Repositories;

//use Cartalyst\Sentinel\Users\UserInterface;

interface UserRepoInterface
{
    /**
     * @param $credentials
     * @param $remember
     * @return mixed
     */
    public function userLogin($credentials, $remember): mixed;
}
