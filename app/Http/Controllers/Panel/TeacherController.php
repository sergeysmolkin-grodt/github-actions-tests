<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserFilterRequest;
use App\Http\Requests\Web\TeacherUpdateRequest;
use App\Repositories\TeacherRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService, protected TeacherRepository $teacherRepository)
    {
        parent::__construct();
    }

    public function index()
    {
        $request = new UserFilterRequest();
        $request->merge(['role' => 'teacher']);

        $teachers = $this->userService->getUsers($request);
        return view('panel.teacher.view', compact('teachers'));
    }

    public function show($id)
    {
        $teacher = $this->teacherRepository->getTeacher($id);
        if (!$teacher) {
            //TODO: Add error when user not found
            $this->index();
        }
        return view('panel.teacher.edit', compact('teacher'));
    }

    /**
     * @param TeacherUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TeacherUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $teacher = $this->teacherRepository->getTeacher($id);
        $this->teacherRepository->updateTeacher($data, $teacher);
        return $this->respondWithSuccess([
            'status' => true,
            'message' => 'Success'
        ]);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id) : JsonResponse
    {
        if ($this->userRepository->deleteUser($id)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }
}
