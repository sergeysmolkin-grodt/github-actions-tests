@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body">
    <section id="configuration">
        <div class="row">
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card" style="min-height: 350px;">
                    <div class="text-center">
                        <div class="card-body">
                            <?php if (!empty($teacher->profile_image)): ?>
                                <img src="<?= getDeliveryBoyProfileImageURL($teacher->profile_image); ?>" class="rounded-circle  height-150" style="width: 150px;" alt="Card image">
                            <?php else: ?>
                                <img src="<?= url('public/admin/app-assets/images/portrait/large/user-profile-default.png'); ?>" class="rounded-circle  height-150" style="width: 150px;" alt="Card image">
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= $teacher->firstname . ' ' . $teacher->lastname ?></h4>
                            <h6 class="card-subtitle text-muted"><?= $teacher->email ?></h6>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="hidden" name="is_active" value="0">
                            <span class="text-danger">Block</span>&nbsp;&nbsp;<input type="checkbox" name="is_active" id="is-active" value="1" class="switchery" data-size="sm" <?php if (@$teacher->is_active == 1): ?> checked <?php endif; ?>/>&nbsp;&nbsp;<span class="text-success">Unblock</span>
                        </div>
                         <div class="form-group">
                            <label>Booking Status</label>
                            <br>
                            <input type="hidden" name="can_be_booked" value="0">
                            <span class="text-danger">Not Available</span>&nbsp;&nbsp;<input type="checkbox" name="can_be_booked" id="can-be-booked" value="1" class="switchery" data-size="sm" <?php if (@$teacher->teacherOptions->can_be_booked == 1): ?> checked <?php endif; ?>/>&nbsp;&nbsp;<span class="text-success">Available</span>
                        </div>

                        <div class="form-group">
                            <label>Trial Lesson Teacher</label>
                            <br>
                            <input type="hidden" name="allows_trial" value="0">
                            <span class="text-danger">OFF</span>&nbsp;&nbsp;<input type="checkbox" name="allows_trial" id="allows-trial" value="1" class="switchery" data-size="sm" <?php if (@$teacher->teacherOptions->allows_trial == 1): ?> checked <?php endif; ?>/>&nbsp;&nbsp;<span class="text-success">ON</span>
                        </div>
                        <!-- //TODO Investigate logic
                        <div class="form-group">
                            <label>Trial lesson status</label>
                            <br>
                            <span class="text-danger">OFF</span>&nbsp;&nbsp;<input type="checkbox" id="teacher-can-booking-trial-session-status-new" class="switchery" data-size="sm" <?php if (@$getCustomerDetails->is_teacher_for_trail_lesson == 1): ?> checked <?php endif; ?>/>&nbsp;&nbsp;<span class="text-success">ON</span>
                        </div>
                        -->
                        <input type="hidden" id="teacher-id" value="<?= @$teacher->id ?>">
                        <li class="list-group-item">
                            <?php if ($teacher->teacherOptions->verification_status != ''): ?>
                                <div>
                                    <select class="select2 form-control" name="verification_status" id="user-verification-status" style="height:35px;border: 2px solid #006472;width: 40%;display: table-caption;">
                                        <option style="padding-top: 10px;" value="pending" <?php if (@$teacher->teacherOptions->verification_status === "pending"): ?> selected <?php endif; ?>>Pending</option>
                                        <option style="padding-top: 10px;" value="rejected" <?php if (@$teacher->teacherOptions->verification_status == "rejected"): ?> selected <?php endif; ?>>Rejected</option>
                                        <option style="padding-top: 10px;" value="verified" <?php if (@$teacher->teacherOptions->verification_status == "verified"): ?> selected <?php endif; ?>>Verified</option>
                                    </select>
                                </div>

                            <?php endif; ?>
                        </li>
                        <li class="list-group-item">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="update-teacher">
                                    Update
                                </button>
                            </div>
                        </li>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="card" style="min-height: 500px;">
                    <div class="card-content">
                        <ul class="list-group list-group-flush">
                            <?php if (!empty($teacher->userDetails->gender)): ?>
                                <li class="list-group-item hidden">
                                    <b>Gender</b>
                                    <span class="float-right"><?= ucfirst($teacher->userDetails->gender) ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($teacher->userDetails->birth_date)): ?>
                                <li class="list-group-item">
                                    <b>Birth Date</b>
                                    <span class="float-right"><?= $teacher->userDetails->birth_date ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($teacher->userDetails->mobile)): ?>
                                <li class="list-group-item">
                                    <b>Phone</b>
                                    <span class="float-right"><?= @$teacher->userDetails->country_code.@$teacher->userDetails->mobile ?></span>
                                </li>
                            <?php endif; ?>
                            <!-- TODO add paypal email if needed
                            <?php if (!empty($customerData->pay_pal_email)): ?>
                                <li class="list-group-item">
                                    <b>PayPal Email</b>
                                    <span class="float-right"><?= $customerData->pay_pal_email ?></span>
                                </li>
                            <?php endif; ?>
                            -->

                            <?php if (!empty($teacher->teacherOptions->bio)): ?>
                                <li class="list-group-item">
                                    <b>Bio</b>
                                    <span class="float-right"><?= $teacher->teacherOptions->bio ?></span>
                                </li>
                            <?php endif; ?>
                              <?php if (!empty($teacher->teacherOptions->attainment)): ?>
                                <li class="list-group-item">
                                    <b>Attainment</b>
                                    <span class="float-right"><?= $teacher->teacherOptions->attainment ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($teacher->totalRatings)): ?>
                                <li class="list-group-item">
                                    <b>Total Ratings</b>
                                    <span class="float-right"><?= $teacher->averageRating ?>&nbsp;&nbsp;(<?= $teacher->totalRatings ?>)</span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($teacher->totalRatings)): ?>
                                <li class="list-group-item">
                                    <b>Average Ratings</b>
                                    <span class="float-right">
                                        <fieldset class="rating">
                                            <?php if ($teacher->averageRating < '1'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled checked id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '1' && $teacher->averageRating < '1.5'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled checked id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '1.5' && $teacher->averageRating < '2'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled checked id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '2' && $teacher->averageRating < '2.5'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled checked id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '2.5' && $teacher->averageRating < '3'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled checked id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '3' && $teacher->averageRating < '3.5'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled checked id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '3.5' && $teacher->averageRating < '4'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled checked id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '4' && $teacher->averageRating < '4.5'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled checked id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating >= '4.5' && $teacher->averageRating < '5'): ?>
                                                <input type="radio" disabled id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled checked id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                            <?php if ($teacher->averageRating == '5'): ?>
                                                <input type="radio" disabled checked id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" disabled  id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" disabled  id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" disabled  id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" disabled  id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" disabled  id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" disabled  id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" disabled  id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" disabled  id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" disabled  id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                            <?php endif; ?>
                                        </fieldset>
                                    </span>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <?php if (!empty($teacher->totalCompletedSessions)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Month wise sessions</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <canvas id="bar_chart" width="800" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-6">-->
                <!--    <div class="card">-->
                <!--        <div class="card-header">-->
                <!--            <h4 class="card-title">Year wise sessions</h4>-->
                <!--            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>                    -->
                <!--        </div>-->
                <!--        <div class="card-content collapse show">-->
                <!--            <div class="card-body">-->
                <!--                <canvas id="bar_chart_for_year" width="800" height="300"></canvas>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        <?php endif; ?>
    </section>
</div>
@stop
