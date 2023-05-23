<?php
namespace App\Http\Services\Impl;

use App\Http\Repositories\CategoryRepoInterface;
use App\Http\Services\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService implements CategoryServiceInterface
{
    protected CategoryRepoInterface $categoryRepository;

    public function __construct(CategoryRepoInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store($request)
    {
        return $this->categoryRepository->store([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }


    public function getList($request): array
    {
        $orderSorts = $request->input('order');
        $dataColumns = $request->input('columns');

        $start = $request->input('start', 1);
        $length = $request->input('length', 10);
        $page = floor($start / $length) + 1;

        $categoryQuery = Category::whereNotNull('id');
        foreach ($orderSorts as $orderSort) {
            $orderSortColumn = $orderSort['column'];
            $dir = $orderSort['dir'];
            $field = $dataColumns[$orderSortColumn]['data'];
            if (!empty($field) && !empty($dir)) {
                $categoryQuery->orderBy($field, $dir);
            }
        }

        $search = $request->input('search');
        if (!empty($search['value'])) {
            $categoryQuery
                ->orWhere('name', 'like', "%{$search['value']}%")
                ->orWhere('slug', 'like', "%{$search['value']}%");
        }

        $categoryPaginate = $categoryQuery->paginate($length, '*', 'categories', $page);
        $recordsTotal = $categoryPaginate->total();

        return [
            'data' => $categoryPaginate->all(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal
        ];
    }

    public function getById($id = null)
    {
        return $this->categoryRepository->getById($id);
    }

    public function update($request = null, $id = null): void
    {
        $data = [
            'name' => $request->name,
            'slug' => str::slug($request->name),
        ];
        $this->categoryRepository->update($data, $id);
    }

    public function delete($id = null): void
    {
        $this->categoryRepository->delete($id);
    }

}
