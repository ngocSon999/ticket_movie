<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface MovieRepoInterface extends BaseRepoInterface
{
    public function getSlide(): Collection;

    public function getMovie(): Collection;

    public function updateToSlide($input): void;
}
