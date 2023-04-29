<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\SentinelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    protected SentinelService $sentinelService;

    public function __construct(SentinelService $sentinelService)
    {
        $this->sentinelService = $sentinelService;
    }

    public function createForm()
    {
        $roles = $this->sentinelService->getRoles();

        return view('admins.users.create_user', compact('roles'));
    }

    public function create(UserRequest $request): RedirectResponse
    {
        $this->sentinelService->createUser($request);

        return redirect()->route('admin.dashboard')->with('success', 'Tạo tài khoản thành công');
    }

    public function index()
    {
        return view('admins.users.index');
    }

    public function getList(Request $request)
    {
        $users = $this->sentinelService->getUser();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('first_name', function ($user) {
                return $user->first_name;
            })
            ->editColumn('last_name', function ($user) {
                return $user->last_name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('phone', function ($user) {
                return $user->phone;
            })
            ->addColumn('role', function ($user) {
                $role = $user->roles()->first();
                return $role->name;
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d-m-Y');
            })
            ->addColumn('action', function ($user) {
                $action = view('admins.users.action', ['row' => $user])->render();
                return $action;
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    }

    public function edit($id)
    {
        $user = $this->sentinelService->getUserById($id);
        $roles = $this->sentinelService->getRoles();

        return view('admins.users.create_user', compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->sentinelService->updateUserById($request, $id);

        return redirect()->route('admin.dashboard')->with('success', 'update tài khoản thành công');
    }

    public function delete($id)
    {
        $this->sentinelService->deleteUserById($id);

        return redirect()->route('users.index')->with('success', 'Xóa tài khoản thành công');
    }
}
