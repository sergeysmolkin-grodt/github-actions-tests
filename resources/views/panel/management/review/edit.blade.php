@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body">
    <section id="configuration">
        <form class="form" id="edit_teacher_review">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-6">
                    <div class="card" style="min-height: 490px;">
                        <div  style="margin-top: -17px;">
                            <div class="card-body">
                                    <div class="form-body">
                                        <h4 class="form-section"><b><i class="icon-docs"></i> Review</b> </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Name</label>
                                                    <input type="text" value="<?= $review->name ?>" class="form-control" placeholder="Name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Location</label>
                                                    <input type="text" value="<?= $review->location ?>" class="form-control" placeholder="Location" name="location" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Review</label>
                                                    <textarea class="form-control" style="width:100%;" rows="8" id="review" name="review" placeholder="Review" required><?= $review->review ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">Image</label>
                                                    <input type="file" class="form-control-file" id="exampleInputFile" name="image" accept="" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <input type="hidden" name="reviewId" class="form-control-file" value="<?= $review->id ?>" required>
                            </div>
                         </div>
                        <hr>
                        <div class="col-xl-1 col-md-1 col-12">
                            <h3 style="text-align:right;">
                                <button type="submit" class="btn btn-primary" id="edit-teacher-review-processing">
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
