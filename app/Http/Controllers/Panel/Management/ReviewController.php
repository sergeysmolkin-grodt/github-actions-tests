<?php

namespace App\Http\Controllers\Panel\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserFilterRequest;
use App\Http\Requests\Web\UpdateStoreReview;
use App\Models\User;
use App\Services\UserService;
use App\Traits\FileTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\TeacherReview;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\Web\StoreReview;

class ReviewController extends Controller
{
    use FileTrait;

    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
        parent::__construct();
    }

    public function index()
    {
        return view('panel.management.review.view', ['teacherReviews' => TeacherReview::all()]);
    }

    public function create()
    {
        return view('panel.management.review.add');
    }

    /**
     * Display edit page of specific user.
     */
    public function edit(string $id): View|Application|Factory
    {
        return view('panel.management.review.edit', ['review' => TeacherReview::find($id)]);
    }

    public function store(StoreReview $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('review_image')) {
            $validated['image'] = $this->uploadFile($request->file('review_image'), 'teacher_reviews', 'public');
        }

        if (TeacherReview::create($validated)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }

    public function update(UpdateStoreReview $request, $id)
    {
        $teacherReview = TeacherReview::find($id);
        $validated = $request->validated();

        if ($request->hasFile('review_image')) {
            if ($teacherReview->image) {
                Storage::disk('public')->delete('teacher_reviews/' . $teacherReview->image);
            }
            $validated['image'] = $this->uploadFile($request->file('review_image'), 'teacher_reviews', 'public');
        }

        if ($teacherReview->update($validated)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Updated successfully'
            ]);
        }
        return $this->respondError();
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id) : JsonResponse
    {
        $teacherReview = TeacherReview::find($id);
        if ($teacherReview->image) {
            Storage::disk('public')->delete('teacher_reviews/' . $teacherReview->image);
        }

        if ($teacherReview->delete()) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }
}
