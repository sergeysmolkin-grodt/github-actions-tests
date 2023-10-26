@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body">
    <section id="configuration">
        <form class="form" id="edit_teacher_video">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-6">
                    <div class="card" style="min-height: 250px;">
                        <div  style="margin-top: -17px;">
                            <div class="card-body">
                                    <div class="form-body">
                                        <h4 class="form-section"><b><i class="icon-docs"></i> Teacher Video</b> </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Name</label>
                                                    <input type="text" value="<?= $video->name ?>" class="form-control" placeholder="Name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Video URL</label>
                                                    <input type="text" value="<?= $video->video ?>" class="form-control" placeholder="Video URL" name="video" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Image</label>
                                                    <input type="file" class="form-control-file" id="exampleInputFile" name="image" accept="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <input type="hidden" name="videoId" class="form-control-file" value="<?= $video->id ?>" required>
                            </div>
                         </div>
                        <hr>
                        <div class="col-xl-1 col-md-1 col-12">
                            <h3 style="text-align:right;">
                                <button type="submit" class="btn btn-primary" id="edit-teacher-video-processing">
                                    Update
                                </button>
                            </h3>
                        </div>
                </div>
            </div>
        </form>
    </section>
</div>
@stop
