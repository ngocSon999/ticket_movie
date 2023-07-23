<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MovieRequest;
use App\Http\Services\MovieServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MovieController extends BaseAdminController
{
    protected MovieServiceInterface $movieService;

    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    public function createForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admins.movies.form_create');
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admins.movies.index');
    }

    public function store(MovieRequest $request): RedirectResponse
    {
        $this->movieService->store($request);

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim mới thành công');
    }
    public function getDataTable(Request $request): JsonResponse
    {
        $data = $this->movieService->getList($request);

        return response()->json($data);
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $movie = $this->movieService->getById($id);

        return view('admins.movies.form_create', compact('movie'));
    }
    public function update(MovieRequest $request, $id): RedirectResponse
    {
        $this->movieService->update($request, $id);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }
    public function delete(int $id): RedirectResponse
    {
        $this->movieService->delete($id);

        return redirect()->route('admin.movies.index')->with('success', 'Xóa thành công');
    }
}
