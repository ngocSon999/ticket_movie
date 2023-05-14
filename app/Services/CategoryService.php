<?php
namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Str;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store($request = null)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        return $this->categoryRepository->store($data);
    }


    public function getList($request = null): array
    {
        $orderSorts = $request->input('order');
        $dataColumns = $request->input('columns');

        $start = $request->input('start', 1);
        $length = $request->input('length', 10);
        $page = floor($start / $length) + 1;

        /** @var Category $categoryQuery */
        $categoryQuery = $this->categoryRepository->model();
        foreach ($orderSorts as $orderSort) {
            $orderSortColumn = $orderSort['column'];
            $dir = $orderSort['dir'];
            $field = $dataColumns[$orderSortColumn]['data'];
            if (!empty($field) && !empty($dir)) {
                $categoryQuery = $categoryQuery::orderBy($field, $dir);
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
