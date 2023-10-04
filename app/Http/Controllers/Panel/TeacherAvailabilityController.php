<?php

namespace App\Http\Controllers\Panel;

use App\DataTransferObjects\AvailabilityData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\TeacherAvailabilityEditRequest;
use App\Repositories\AppointmentRepository;
use App\Repositories\AvailabilityExceptionRepository;
use App\Repositories\TeacherRepository;
use App\Services\AvailabilityExceptionService;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;


class TeacherAvailabilityController extends Controller
{
    /**
     * @param AvailabilityService $availabilityService
     * @param AvailabilityExceptionService $availabilityExceptionService
     * @param TeacherRepository $teacherRepository
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(
        protected AvailabilityService $availabilityService,
        protected AvailabilityExceptionService $availabilityExceptionService,
        protected TeacherRepository $teacherRepository,
        protected AppointmentRepository $appointmentRepository,
        protected AvailabilityExceptionRepository $availabilityExceptionRepository
    )
    {
        parent::__construct();
    }

    public function show($id)
    {
        if(!$teacher = $this->teacherRepository->getTeacher($id)) {
            //TODO: Add error when user not found
            $this->index();
        }

        $availabilities = $this->availabilityService->getFormattedAvailabilityForTeacher($id);

        $availabilityExceptions = $this->availabilityExceptionService->getIrregularTeacherSchedule($id);

        $holidays = $this->availabilityExceptionRepository->getHolidaysForTeacher($id);

        return view('panel.teacher.availabilities', compact('teacher', 'availabilities', 'availabilityExceptions', 'holidays'));
    }

    /**
     * @param TeacherAvailabilityEditRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function edit(TeacherAvailabilityEditRequest $request, $id) : JsonResponse
    {
        $data = $request->validated();

        foreach ($data['availabilities'] as $availability) {
            $availability['teacher_id'] = $id;
            $availability = new AvailabilityData(...$availability);

            $this->availabilityService->changeAvailability($availability);
        }
        // TODO add DB Transaction

        //TODO change student auto schedule who has the same teacher

        return $this->respondWithSuccess([
            'status' => true,
            'message' => 'Success'
        ]);
    }
}
