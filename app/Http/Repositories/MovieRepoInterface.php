<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface MovieRepoInterface extends BaseRepoInterface
{
    public function getSlide(): Collection;

    public function getMovie(): Collection;

    public function updateToSlide($input): void;

    public function storeMovie(array $data, $model): mixed;

    public function updateMovie(array $data, $id, $model): mixed;

    public function getMovieById(int $id, $model): mixed;
}
