<?php

namespace App\Http\Repositories;

interface CategoryRepoInterface
{
    public function model();

    public function store(array $data);

    public function getById(int $id);

    public function update(array $data, int $id);

    public function delete(int $id): void;
}
