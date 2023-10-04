<?php

namespace App\Http\Controllers\Panel;

use App\DataTransferObjects\AvailabilityData;
use App\DataTransferObjects\HolidayData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\TeacherAvailabilityExceptionRequest;
use App\Http\Requests\Web\TeacherHolidayStoreRequest;
use App\Repositories\AppointmentRepository;
use App\Repositories\AvailabilityExceptionRepository;
use App\Services\AppointmentService;
use App\Services\AvailabilityExceptionService;
use App\Traits\DateTimeTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class TeacherAvailabilityExceptionController extends Controller
{
    use DateTimeTrait;

    public function __construct(
        protected AppointmentService $appointmentService,
        protected AppointmentRepository $appointmentRepository,
        protected AvailabilityExceptionRepository $availabilityExceptionRepository,
        protected AvailabilityExceptionService $availabilityExceptionService
    ) {}

    /**
     * @param TeacherAvailabilityExceptionRequest $request
     * @return JsonResponse
     */
    public function store(TeacherAvailabilityExceptionRequest $request): JsonResponse
    {
        //TODO add DB transaction
        $data = $request->validated();
        $data['date'] = $this->getYMDHyphenFormat($data['date']);
        $data = new AvailabilityData(...$data);

        if ($message = $this->availabilityExceptionService->basicChecks($data)) {
            return $this->respondError($message);
        }

        $appointments = $this->appointmentRepository->getAppointmentsForTeacherByDate($data->teacher_id, $data->date);
        $currentAdmin = Auth::user();
        $cancelledBy = "$currentAdmin->firstname $currentAdmin->lastname";

        foreach ($appointments as $appointment) {
            $this->appointmentService->checkAppointmentWithAvailability($appointment, $cancelledBy, $data);
        }
        $this->availabilityExceptionService->updateOrCreate($data);

        return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
    }

    /**
     * @param TeacherAvailabilityExceptionRequest $request
     * @return JsonResponse
     */
    public function delete(TeacherAvailabilityExceptionRequest $request): JsonResponse
    {
        $date = $this->getYMDHyphenFormat($request['date']);
        $this->availabilityExceptionRepository->deleteIrregularTeacherScheduleByDate($request['teacher_id'], $date);
        return $this->respondWithSuccess([
            'status' => true,
            'message' => 'Success'
        ]);
    }

    /**
     * @param TeacherHolidayStoreRequest $request
     * @return JsonResponse
     */
    public function storeHoliday(TeacherHolidayStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['date'] = $this->getYMDHyphenFormat($request['date']);
        $holiday = new HolidayData(...$validated);

        $this->availabilityExceptionRepository->firstOrCreateHoliday($holiday);
        return $this->respondWithSuccess([
            'status' => true,
            'message' => 'Success'
        ]);
    }
}
