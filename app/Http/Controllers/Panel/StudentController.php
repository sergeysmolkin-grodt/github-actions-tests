<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use App\Models\User;
use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DataExportService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Http\Requests\Web\StudentUpdateRequest;
use App\Models\Plan;

class StudentController extends Controller
{
    public function __construct(protected StudentRepositoryInterface $studentRepository, protected CompanyRepositoryInterface $companyRepository) {}

    public function index(): View|Application|Factory
    {
        return view('panel.student.view', [ 'countryCode' => '']);
    }

    /**
     * Display edit page of specific user.
     */
    public function edit(string $id): View|Application|Factory
    {
        $user = User::with(['userDetails', 'studentOptions', 'companySubscription'])->find($id);

        if (!$user) {
            //To Do: Add error when user not found
            $this->index();
        }
        return view('panel.student.edit', ['customerData' => $user, 'companies' => $this->companyRepository->all(), 'plans' => Plan::all()]);
    }


    /**
     * Download Excel with students.
     */
    public function export(string $format): BinaryFileResponse
    {
        return Excel::download(new DataExportService(), 'Students.'.$format);
    }

    /**
     * Update specific student.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StudentUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        try {
            $status = $this->studentRepository->update(array_merge($validated, ['id' => $id]));
        } catch (\Exception $exception) {
            return $this->respondWithSuccess([
                'status' => 0,
                'message' => $exception->getMessage()
            ]);
        }
        return $this->respondWithSuccess([
            'status' => $status,
            'message' => 'Success'
        ]);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        if ($this->studentRepository->delete($id)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }

}
