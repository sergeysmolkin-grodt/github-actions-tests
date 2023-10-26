<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TeacherReview;

class TeacherReviewController extends Controller
{
    public function index()
    {
        return $this->respondWithSuccess([
            'message' => __('Resource response'),
            'resultCount' => count(TeacherReview::all()),
            'teacherReviews' => TeacherReview::all()
        ]);
    }

    /**
     * Display specific Review.
     */
    public function show(string $id)
    {
        return $this->respondWithSuccess([
            'message' => __('Resource response'),
            'teacherReviews' => TeacherReview::find($id)
        ]);
    }


}
