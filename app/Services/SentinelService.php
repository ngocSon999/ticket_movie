<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;

class SentinelService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate($request): UserInterface|bool
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $remember = (bool)$request->remember;

        return $this->userRepository->userLogin($credentials, $remember);
    }

    public function getRoles()
    {
        return Sentinel::getRoleRepository()->where('slug', '!=', 'super-admin')->get();
    }

    public function createUser($request)
    {
        $credentials = [
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'phone' => $request->phone,
          'password' => $request->password,
        ];
        $userAdmin = Sentinel::registerAndActivate($credentials);
        $userAdmin->roles()->attach(Sentinel::findRoleById($request->role));
    }

    public function getUser($slug = null)
    {
        if (!empty($slug)) {
            $users = Sentinel::getUserRepository()->whereHas('roles', function ($query) use ($slug) {
               $query->where('slug', $slug);
            })->get();

            return $users;
        }else{
            $users = Sentinel::getUserRepository()->whereHas('roles', function ($query) use ($slug) {
                $query->where('slug','!=', 'super-admin');
            })->get();

            return $users;
        }
    }

    public function getUserById($id)
    {
        return Sentinel::findById($id);
    }

    public function updateUserById($request, $id)
    {
        $user = Sentinel::findById($id);
        $credentials = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        if (!empty($request->password)) {
            $credentials['password'] = $request->password;
        }
        Sentinel::update($user, $credentials);
    }
    public function deleteUserById($id)
    {
        $user = Sentinel::findById($id);
        $user->delete();
    }
}
