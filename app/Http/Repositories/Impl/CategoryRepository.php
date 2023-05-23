<?php
namespace App\Http\Repositories\Impl;

use App\Http\Repositories\CategoryRepoInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepoInterface
{
    public function model()
    {
        return Category::class;
    }

    public function store(array $data)
    {
        return Category::create($data);
    }

    public function getById(int $id)
    {
        return Category::find($id);
    }

    public function update(array $data, int $id)
    {
        if (!empty($data) && !empty($id)) {
            $category = Category::find($id);
            $category->update($data);
        }
    }

    public function delete(int $id): void
    {
        if (!empty($id)) {
            $category = Category::find($id);
            $category->delete();
        }
    }
}
