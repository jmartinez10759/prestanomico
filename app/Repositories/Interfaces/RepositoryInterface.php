<?php namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function save(array $data, array $attributes);

    public function delete($id);

    public function getById($id);

    public function filterIn(string $field, array $data);

    public function getBy(array $attributes);

    public function filterBy(array $data): Collection;

}