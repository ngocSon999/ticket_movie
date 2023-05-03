<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

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

    public function getAllRoles()
    {
        return Sentinel::getRoleRepository()->get();
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
    public function getAllUser($slug = null)
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
    public function getDataUserAndSearch($request = null)
    {
        $orderSorts = $request->input('order');
        $dataColumns = $request->input('columns');

        $start = $request->input('start', 1);
        $length = $request->input('length', 10);
        $page = floor($start / $length) + 1;

        $search = $request->input('search');

        /** @var LengthAwarePaginator $userQuery */
        $userQuery = Sentinel::getUserRepository()->with(['roles']);

        if (!empty($search['value'])) {
            $userQuery
                ->orWhere('email', 'like', "%{$search['value']}%")
                ->orWhere('phone', 'like', "%{$search['value']}%")
                ->orWhere('first_name', 'like', "%{$search['value']}%")
                ->orWhere('last_name', 'like', "%{$search['value']}%");
        };

        foreach ($orderSorts as $orderSort) {
            $orderSortColumn = $orderSort['column'];
            $dir = $orderSort['dir'];
            $field = $dataColumns[$orderSortColumn]['data'];
            if (!empty($field) && !empty($dir)) {
                $userQuery->orderBy($field, $dir);
            }
        }
        if($request->input('user_name')) {
            $userQuery->where('first_name', 'like', "%{$request->input('user_name')}%");
        }
        if($request->input('email')) {
            $userQuery->where('email', $request->input('email'));
        }
        if(!empty($request->input('role_id'))) {
            $roleId = $request->input('role_id');
            $userQuery->whereHas('roles', function ($query) use ($roleId) {
                $query->where('id', $roleId);
            });
        }
        if(!empty($request->input('start_date'))) {
            $startDate = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
            $userQuery->whereDate('created_at', '>=', $startDate);
        }
        if(!empty($request->input('end_date'))) {
            $endDate = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
            $userQuery->whereDate('created_at', '<=', $endDate);
        }


        /** @var LengthAwarePaginator $usersPaginate */
        $usersPaginate = $userQuery->paginate($length, '*', 'users', $page);
        $recordsTotal = $usersPaginate->total();

        return [
            'data' => $usersPaginate->all(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal
        ];
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
        $user = Sentinel::update($user, $credentials);
        if ($request->role) {
            $roleUpdate = Sentinel::findRoleById($request->role);
            $user->roles()->sync($roleUpdate);
        }
    }
    public function deleteUserById($id)
    {
        $user = Sentinel::findById($id);
        $user->delete();
    }
}
