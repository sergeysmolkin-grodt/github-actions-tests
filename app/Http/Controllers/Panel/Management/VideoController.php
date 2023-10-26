<?php

namespace App\Http\Controllers\Panel\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserFilterRequest;
use App\Http\Requests\Web\CreateVideoRequest;
use App\Http\Requests\Web\UpdateStoreReview;
use App\Http\Requests\Web\UpdateVideoRequest;
use App\Models\TeacherVideo;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    use FileTrait;

    public function index()
    {
       return view('panel.management.video.view', ['teacherVideos' => TeacherVideo::all()]);
    }

    public function create()
    {
        return view('panel.management.video.add');
    }

    /**
     * Display edit page of specific video.
     */
    public function edit(string $id): View|Application|Factory
    {
        return view('panel.management.video.edit', ['video' => TeacherVideo::find($id)]);
    }

    public function store(CreateVideoRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadFile($request->file('image'), 'teacher_videos', 'public');
        }

        if (TeacherVideo::create($validated)) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }

    public function update(UpdateVideoRequest $request, $id)
    {
        $teacherVideo = TeacherVideo::find($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($teacherVideo->image) {
                Storage::disk('public')->delete('teacher_videos/' . $teacherVideo->image);
            }
            $validated['image'] = $this->uploadFile($request->file('image'), 'teacher_videos', 'public');
        }

        if ($teacherVideo->update($validated)) {
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
        $teacherVideo= TeacherVideo::find($id);
        if ($teacherVideo->image) {
            Storage::disk('public')->delete('teacher_videos/' . $teacherVideo->image);
        }

        if ($teacherVideo->delete()) {
            return $this->respondWithSuccess([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return $this->respondError();
    }
}
