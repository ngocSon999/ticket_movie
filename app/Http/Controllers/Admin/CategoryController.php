<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected  CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('admins.categories.index');
    }

    public function createForm()
    {
        return view('admins.categories.form_create');
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->store($request);

        return redirect()->route('categories.index');
    }

    public function getList(Request $request)
    {
        $data = $this->categoryService->getList($request);

        return response()->json($data);

    }

    public function edit($id)
    {
        $category = $this->categoryService->getById($id);
        return view('admins.categories.form_create', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->update($request, $id);

        return redirect()->route('categories.index')->with('success', 'update danh mục thành công!');
    }

    public function delete($id)
    {
        $this->categoryService->delete($id);

        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
