<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateTeacherOptionsRequest;
use App\Repositories\AppointmentRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\RatingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class TeacherOptionsController extends Controller
{
    public function __construct(
        protected RatingRepository $ratingRepository,
        protected AppointmentRepository $appointmentRepository,
        protected TeacherRepository $teacherRepository
    ) {
        parent::__construct();
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $teacher = $this->teacherRepository->getTeacher($id);

        if (!$teacher) {
            //TODO: Add error when user not found
            $this->index();
        }

        $teacher->totalRatings = $this->ratingRepository->getTotalRatingsForTeacher($id);
        $teacher->averageRating = $this->ratingRepository->getAverageRatingForTeacher($id);
        $teacher->totalCompletedSessions = $this->appointmentRepository->getTotalCompletedSessionsForTeacher($id);
        return view('panel.teacher.view_details', compact('teacher'));
    }

    /**
     * @param UpdateTeacherOptionsRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateTeacherOptionsRequest $request, $id) : JsonResponse
    {
        $validated = $request->validated();
        $teacher = $this->teacherRepository->getTeacher($id);
        $this->teacherRepository->updateTeacher($validated, $teacher);
        return $this->respondWithSuccess([
            'message' => __('Teacher updated successfully'),
            ]);
    }
}
