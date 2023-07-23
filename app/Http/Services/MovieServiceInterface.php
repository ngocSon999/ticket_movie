<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface MovieServiceInterface extends BaseServiceInterface
{
    public function store(Request $request);

    public function getList(Request $request);
    public function getById(int $id);

    public function update(Request $request, int $id);

    public function delete(int $id);
}
