<?php
namespace App\Repositories;

use App\Models\Category;
class CategoryRepository
{
    public function model()
    {
        return Category::class;
    }

    public function store($data)
    {
        return Category::create($data);
    }

    public function getById($id = null)
    {
        return Category::find($id);
    }

    public function update($data = null, $id = null)
    {
        if (!empty($data) && !empty($id)) {
            $category = Category::find($id);
            $category->update($data);
        }
    }

    public function delete($id = null): void
    {
        if (!empty($id)) {
            $category = Category::find($id);
            $category->delete();
        }
    }
}
