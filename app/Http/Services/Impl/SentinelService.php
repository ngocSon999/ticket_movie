<?php
namespace App\Http\Services\Impl;

use App\Http\Services\SentinelServiceInterface;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class SentinelService implements SentinelServiceInterface
{
    public function authenticate(Request $request): UserInterface|bool
    {
        return $this->userRepository->userLogin([
            'email' => $request->email,
            'password' => $request->password,
        ], (bool) $request->remember);
    }

    public function getRoles()
    {
        return Sentinel::getRoleRepository()->where('slug', '!=', 'super-admin')->get();
    }

    public function getAllRoles()
    {
        return Sentinel::getRoleRepository()->get();
    }

    public function createUser(Request $request): void
    {
        $userAdmin = Sentinel::registerAndActivate([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        $userAdmin->roles()->attach(Sentinel::findRoleById($request->role));
    }
    public function getAllUser(?string $slug)
    {
        if (!empty($slug)) {
            return Sentinel::getUserRepository()->whereHas('roles', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->get();
        }

        return Sentinel::getUserRepository()->whereHas('roles', function ($query) use ($slug) {
            $query->where('slug','!=', 'super-admin');
        })->get();
    }
    public function getDataUserAndSearch(Request $request): array
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

    public function getUserById($id): User
    {
        return Sentinel::findById($id);
    }

    public function updateUserById($request, $id): void
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
    public function deleteUserById($id): void
    {
        $user = Sentinel::findById($id);
        $user->delete();
    }
}
