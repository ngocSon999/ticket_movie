<?php

namespace App\Http\Services\Impl;

use App\Http\Repositories\MovieRepoInterface;
use App\Http\Services\MovieServiceInterface;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieService extends BaseService implements MovieServiceInterface
{
    protected MovieRepoInterface $movieRepository;

    public function __construct(MovieRepoInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function store(Request $request)
    {
        $startDate = $this->formatDate($request->start_date);
        $endDate = $this->formatDate($request->end_date);
        $dataInput = [
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'age_limit' => $request->age_limit,
            'trailer' => $request->trailer,
            'director_id' => $request->director_id,
            'category_id' => $request->category_id
        ];
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $fileName = $file->getClientOriginalName();
            $ext = $file->extension();
            $filesize = $file->getSize();
            if (strcasecmp($ext, 'jpg') == 0 || strcasecmp($ext, 'jpeg') == 0
                || strcasecmp($ext, 'png') == 0) {
                if ($filesize < 7000000) {
                    $file->move('upload/movies/', $fileName);
                    $dataInput['banner'] = 'upload/movies/' . $fileName;
                }
            }
        }

        return $this->movieRepository->storeMovie($dataInput, Movie::class);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getList(Request $request): array
    {
        $request->merge([
            'filter' => [
                'searchColumns' => [
                    'name',
                    'description'
                ],
                'inputFields' => [
                    'name' => $request->movie_name,
                ],
                'start_date' => [
                    'start_date' => $request->start_date,
                ],
                'end_date' => [
                    'start_date' => $request->end_date,
                ]
            ],
        ]);

        return $this->getDataBuilder($request, Movie::class);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return $this->movieRepository->getById($id, Movie::class);
    }

    public function getMovieById($id): mixed
    {
        return $this->movieRepository->getById($id, Movie::class);
    }

    public function update($request = null, $id = null): void
    {
        $startDate = $this->formatDate($request->start_date);
        $endDate = $this->formatDate($request->end_date);
        $dataInput = [
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'age_limit' => $request->age_limit,
            'trailer' => $request->trailer,
            'director_id' => $request->director_id,
            'category_id' => $request->category_id
        ];
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            if (!empty($file)){
                $movie = $this->movieRepository->getById($id, Movie::class);
                $image_path =$movie->banner;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $fileName = $file->getClientOriginalName();
            $ext = $file->extension();
            $filesize = $file->getSize();
            if (strcasecmp($ext, 'jpg') == 0 || strcasecmp($ext, 'jpeg') == 0
                || strcasecmp($ext, 'png') == 0) {
                if ($filesize < 7000000) {
                    $file->move('upload/movies/', $fileName);
                    $dataInput['banner'] = 'upload/movies/' . $fileName;
                }
            }
        }

        $this->movieRepository->updateMovie($dataInput, $id, Movie::class);
    }

    public function delete($id = null): void
    {
        $this->movieRepository->delete($id,  Movie::class);
    }

    public function updateToSlide($input): void
    {
        $this->movieRepository->updateToSlide($input);
    }
}
