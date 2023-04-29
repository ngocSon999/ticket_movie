<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SentinelService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use \Illuminate\Contracts\Foundation\Application as ContractApplication;

class LoginController extends Controller
{
    protected SentinelService $sentinelService;

    public function __construct(
        SentinelService $sentinelService
    )
    {
        $this->sentinelService = $sentinelService;
    }

    public function login(): Factory|View|Application|RedirectResponse|ContractApplication
    {
        if (Sentinel::check()) {
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công');
        }

        return view('admins.login.form_login');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        if ($this->sentinelService->authenticate($request)) {
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công');
        }

        return redirect()->route('admin.user.login')->with('danger', 'Tài khoản hoặc mật khẩu đăng nhập không chính xác');
    }

    public function logout(): RedirectResponse
    {
        Sentinel::logout();

        return redirect()->route('admin.dashboard');
    }
}
