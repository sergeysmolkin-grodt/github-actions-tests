<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Interfaces\CompanyRepositoryInterface;
use Rinvex\Country\CountryLoader;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function index(): View|Application|Factory
    {
        $companies = $this->companyRepository->all();
        return view('panel.company.view', ['companies' => $companies]);
    }

    public function create(): View|Application|Factory
    {
        return view('panel.company.add', ['countries' => CountryLoader::countries()]);
    }

    public function edit($id): View|Application|Factory
    {
        return view('panel.company.edit', ['company' => $this->companyRepository->find($id), 'countries' => CountryLoader::countries()]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        if ($this->companyRepository->update($request->all(), $id)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }


    public function store(Request $request): JsonResponse
    {
        if ($this->companyRepository->create($request->all())) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }

    public function show($id): bool
    {
        $company = $this->companyRepository->find($id);
        //ToDo Add appropriate return
        return true;
    }

    public function destroy($id): JsonResponse
    {
        if ($this->companyRepository->delete($id)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }
}
