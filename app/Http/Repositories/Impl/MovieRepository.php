<?php
namespace App\Http\Repositories\Impl;

use App\Http\Repositories\MovieRepoInterface;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository extends BaseRepository implements MovieRepoInterface
{
    public function getSlide(): Collection
    {
        return Movie::where('add_to_slide', 1)->get();
    }

    public function getMovie(): Collection
    {
        $now = Carbon::now();
        $endDate = Carbon::create($now)->addDays(30);

        return Movie::whereBetween('start_date', [$now, $endDate])->get();
    }

    public function updateToSlide($input): void
    {
        $movie = Movie::find($input['id']);
        $movie->update([
           'add_to_slide' =>  $input['selectValue']
        ]);
    }
}
