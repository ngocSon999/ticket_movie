<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\SentinelService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected SentinelService $sentinelService;

    public function __construct(SentinelService $sentinelService)
    {
        $this->sentinelService = $sentinelService;
    }

    public function index()
    {
        $users = $this->sentinelService->getAllUser();
        $roles = $this->sentinelService->getAllRoles();

        return view('admins.users.index', compact('users', 'roles'));
    }

    public function getList(Request $request)
    {

        $data = $this->sentinelService->getDataUserAndSearch($request);

        return response()->json($data);
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
