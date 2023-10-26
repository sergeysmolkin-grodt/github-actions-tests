<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TeacherVideo;

class TeacherVideoController extends Controller
{
    public function index()
    {
        return $this->respondWithSuccess([
            'message' => __('Resource response'),
            'resultCount' => count(TeacherVideo::all()),
            'teacherReviews' => TeacherVideo::all()
        ]);
    }

    /**
     * Display specific Video.
     */
    public function show(string $id)
    {
        return $this->respondWithSuccess([
            'message' => __('Resource response'),
            'teacherReviews' => TeacherVideo::find($id)
        ]);
    }


}
