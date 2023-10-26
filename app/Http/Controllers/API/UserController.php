<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\BecomeTeacherData;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BecomeTeacherRequest;
use App\Http\Requests\API\SetRemindersOptionsRequest;
use App\Http\Requests\API\UserFilterRequest;
use App\Interfaces\StudentRepositoryInterface;
use App\Models\StudentRemindersOptions;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\StudentRepository;
use App\Http\Resources\StudentRemindersOptionsResource;
use App\DataTransferObjects\StudentRemindersOptionsData;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
        protected StudentRepositoryInterface $studentRepository
    )
    {
        parent::__construct();
    }

    /**
     * @param UserFilterRequest $request
     * @return JsonResponse
     */
    public function index(UserFilterRequest $request)
    {
        //TODO: role restriction
        try {
            $users = $this->userService->getUsers($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->respondError(__('An error occurred while retrieving users'));
        }

        return $this->respondWithSuccess([
            'message' => __('Resource response'),
            'resultCount' => count($users),
            'users' => $users
        ]);
    }

    /**
     * @param BecomeTeacherRequest $request
     * @return JsonResponse
     */
    public function becomeTeacher(BecomeTeacherRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $teacherData = new BecomeTeacherData(...$validated);
            $this->userService->becomeTeacher($teacherData);
        } catch (\Exception $e) {
            Log::error("Error in becomeTeacher: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess([
            'message' => __('You have successfully become a teacher'),
            'id' => Auth::user()->id
        ]);
    }

    public function getRemindersOptions(): JsonResponse
    {
        if (is_null($studentRemindersOptions = $this->studentRepository->getRemindersOptions($this->userId))) {
            return $this->respondError(__('An error occurred while retrieving student reminders options'));
        }

        return $this->respondWithSuccess(new StudentRemindersOptionsResource($studentRemindersOptions));

    }

    public function setRemindersOptions(SetRemindersOptionsRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $this->userId;

        $this->studentRepository->setRemindersOptions(new StudentRemindersOptionsData(...$validated));

        return $this->respondWithSuccess(['message' => 'Student reminders options saved successfully']);
    }
}
