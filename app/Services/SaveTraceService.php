<?php
namespace App\Services;

use App\Models\SaveTrace;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SaveTraceService
{
    public function saveTraces($collect, $action = null)
    {
        $data = [
            'user_id' => Sentinel::getUser()->id,
            'record_id' => $collect->id,
            'table_name' => $collect->getTableName(),
            'table_type' => $collect->getTable(),
            'action' => $action,
        ];

        SaveTrace::create($data);
    }
}
