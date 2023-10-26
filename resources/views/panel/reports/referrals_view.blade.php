@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="<?= config('app.url').'/reports/referrals' ?>" class="form" id="student_referral_form_submit">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select_from_date_for_student_referral">Select From Date</label>
                                                <input type="text" value="<?= $filters['from_date'] ?? ''?>" id="select_from_date_for_student_referral" class="form-control datepicker date" data-provide="datepicker" placeholder="Select From Date" name="from_date" readonly >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="select_to_date_for_student_referral">Select To Date</label>
                                                <input type="text" value="<?= $filters['to_date'] ?? ''?>" id="select_to_date_for_student_referral" class="form-control datepicker date" data-provide="datepicker" placeholder="Select To Date" name="to_date" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="select_student_is_gift_sessions_assigned">Is Gift Sessions Assigned</label><br>
                                            <select class="form-control select2" id="select_student_is_gift_sessions_assigned" style="height: calc(2.25rem + 10px);width:100%;" name="is_gift_sessions_assigned">
                                                <option value="">Is Gift Sessions Assigned</option>
                                                <option <?= isset($filters['is_gift_sessions_assigned']) && $filters['is_gift_sessions_assigned'] === '1' ? 'selected' : '' ?> value="1">Yes</option>
                                                <option <?= isset($filters['is_gift_sessions_assigned']) && $filters['is_gift_sessions_assigned'] === '0' ? 'selected' : '' ?> value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="student-referral-processing-processing" class="btn btn-primary">
                                        Search
                                    </button>
                                    <a href="<?= config('app.url').'/reports/referrals' ?>" class="btn btn-primary">
                                        Clear Filter
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard" style="overflow: auto;">
                            <table id="student-referrals-lists-datatable" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>Student Name</th>
                                        <th>Student Phone</th>
                                        <th>Referer Name</th>
                                        <th>Referer Phone</th>
                                        <th>Is Gift Sessions Assigned</th>
                                        <th>Membership Purchased Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($referrals as $referral): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $referral->user->firstname .' '. $referral->user->lastname ?></td>
                                                <td><?= $referral->user->userDetails->country_code . $referral->user->userDetails->mobile ?></td>
                                                <td><?= $referral->referralUser->firstname .' '. $referral->referralUser->lastname ?></td>
                                                <td><?= $referral->referralUser->userDetails->country_code . $referral->referralUser->userDetails->mobile ?></td>
                                                <td><?= $referral->is_gift_sessions_assigned ? 'Yes' : 'No' ?></td>
                                                <td><?= $referral->date ?></td>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
