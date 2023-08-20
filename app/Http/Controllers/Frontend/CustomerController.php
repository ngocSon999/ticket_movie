<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CustomerRepoInterface;
use App\Http\Requests\CustomerRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected CustomerRepoInterface $customerRepository;

    public function __construct(
        CustomerRepoInterface $customerRepository,
    )
    {
        $this->customerRepository = $customerRepository;
    }

    public function createForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('frontend.customer.create_form');
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        try {
            $this->customerRepository->register($request->all());

            return redirect()->route('web.index')->with('success', 'Đăng ký tài khoản thành công');
        } catch (\Exception $e) {
            return redirect()->route('web.index')->with('warning', 'Có lỗi xảy ra vui  lòng thử lại');
        }
    }
}
