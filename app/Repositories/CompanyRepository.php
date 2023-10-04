<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(protected Company $companyModel) {}

    public function all(): Collection
    {

        return $this->companyModel->all();
    }

    public function find($id): ?Company
    {
        return $this->companyModel->find($id);
    }

    public function create(array $data): ?Company
    {
        return $this->companyModel->create($data);
    }

    public function update(array $data, $id): ?Company
    {
        $company = $this->find($id);
        $company->update($data);
        return $company;
    }

    public function delete($id): bool
    {
        $this->find($id)->delete();
        return true;
    }
}
