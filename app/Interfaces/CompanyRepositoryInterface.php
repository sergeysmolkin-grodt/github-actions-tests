<?php

namespace App\Interfaces;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function all(): Collection|null;

    public function find($id): Company|null;

    public function create(array $data): Company|null;

    public function update(array $data, $id): Company|null;

    public function delete($id): bool;
}
