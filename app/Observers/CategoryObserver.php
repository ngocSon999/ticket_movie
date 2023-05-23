<?php

namespace App\Observers;

use App\Http\Services\Impl\SaveTraceService;
use App\Models\Category;

class CategoryObserver
{
    protected SaveTraceService $saveTrace;

    public function __construct(SaveTraceService $saveTrace)
    {
        $this->saveTrace = $saveTrace;
    }
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->saveTrace->saveTraces($category, 'create');
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->saveTrace->saveTraces($category, 'update');
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->saveTrace->saveTraces($category, 'delete');
    }
}
