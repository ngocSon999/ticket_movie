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

    public function storeMovie(array $data, $model): mixed
    {
        $categoryIds = $data['category_id'];
        unset($data['category_id']);
        $movie = $model::create($data);
        $movie->categories()->attach($categoryIds);

        return $movie;
    }
    public function updateMovie(array $data, $id, $model): mixed
    {
        $categoryIds = $data['category_id'];
        unset($data['category_id']);
        $movie = $model::find($id);
        if (empty($movie)) {
            abort(404);
        }
        $movie->update($data);
        $movie->categories()->sync($categoryIds);

        return $movie;
    }

    public function getMovieById(int $id, $model): mixed
    {
        return $model::where('id', $id)->with('categories')->first();
    }
}
