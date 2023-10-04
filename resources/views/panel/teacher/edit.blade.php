@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Edit Teacher Info</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="edit_coach_submit">
                                <div class="form-body">
                                    <div class="row">
                                        <input type="hidden" id="teacher_id" value="<?= @$teacher->id ?>" class="form-control" name="id">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">First Name</label>
                                                <input type="text" value="<?= @$teacher->firstname ?>" class="form-control" placeholder="First Name" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Last Name</label>
                                                <input type="text" value="<?= @$teacher->lastname ?>" class="form-control" placeholder="Last Name" name="lastname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Email</label>
                                                <input type="email" value="<?= @$teacher->email ?>" class="form-control" placeholder="Email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Phone No</label>
                                                        <input type="text" value="<?= @$teacher->userDetails->country_code ?>"
                                                               class="form-control" placeholder="Phone No" name="country_code"
                                                               required maxlength="4" minlength="2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"></label>
                                                        <input type="text" value="<?= @$teacher->userDetails->mobile ?>" class="form-control" placeholder="Phone No" name="mobile" required maxlength="20">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Paycall number</label>
                                                <input type="number" value="<?= 'plug'/*@$customerData->pay_call_premium_no*/ ?>" class="form-control" placeholder="Paycall number" name="payCallPremiumNo" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Video Link </label>
                                                <!-- TODO Study whether it is necessary to transfer the display and saving of video as in the old backend -->
                                                <input type="text" value="<?= @$teacher->teacherOptions->introduction_video ?>" class="form-control" placeholder="Video Link" name="introduction_video">
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden">
                                            <div class="form-group">
                                                <label for="projectinput1">Video <span style="color:red;">( Maximum file size 10MB )</span></label>
                                                <input type="file" class="form-control-file" id="exampleInputFile" name="teacher_video" accept="video/mp4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="projectinput1">English Type</label>
                                            <div class="form-group">
                                                <input type="hidden" value="0" name="is_teacher_for_business" >
                                                <input type="checkbox" <?php if($teacher->teacherOptions->is_teacher_for_business): echo 'checked'; endif; ?> value="1" name="is_teacher_for_business" >
                                                <label for="input-12">Business</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="projectinput1">&nbsp;</label>
                                            <div class="form-group">
                                                <input type="hidden" value="0" name="is_teacher_for_children" >
                                                <input type="checkbox" <?php if($teacher->teacherOptions->is_teacher_for_children): echo 'checked'; endif; ?> value="1" name="is_teacher_for_children"  >
                                                <label for="input-12">Children</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="projectinput1">&nbsp;</label>
                                            <div class="form-group">
                                                <input type="hidden" value="0" name="is_teacher_for_beginner" >
                                                <input type="checkbox" <?php if($teacher->teacherOptions->is_teacher_for_beginner): echo 'checked'; endif; ?> value="1" name="is_teacher_for_beginner"  >
                                                <label for="input-12">Beginner</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="coach-info-update-processing" onMouseOver="this.style.color='#fff'" onMouseOut="this.style.color='#fff'" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@stop
