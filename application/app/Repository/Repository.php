<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function get(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Collection
    {
        return $this->model->create($data);
    }
}
