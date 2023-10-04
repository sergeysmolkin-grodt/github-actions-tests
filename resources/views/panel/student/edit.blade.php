@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Student Info</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="edit_customer_submit">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">First Name</label>

                                                <input type="text" value="<?= @$customerData->firstname ?>" class="form-control" placeholder="First Name" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Last Name</label>
                                                <input type="text" value="<?= @$customerData->lastname ?>" class="form-control" placeholder="Last Name" name="lastname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">E-mail</label>
                                                <input type="text" name="email" value="<?= @$customerData->email ?>" class="form-control" placeholder="E-mail">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">Alternate E-mail</label>
                                                <input type="text" name="alt_email" value="<?= @$customerData->alternet_email ?>" class="form-control" placeholder="Alternate E-mail">
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden">
                                            <div class="form-group">
                                                <label for="projectinput4">Gender</label>
                                                <select class="form-control" name="gender" style="height: calc(2.25rem + 10px);">
                                                    <option value="">Select Gender</option>
                                                    <option <?php if(@$customerData->gender == 'Male'): echo "selected"; endif; ?> value="Male">Male</option>
                                                    <option <?php if(@$customerData->gender == 'Female'): echo "selected"; endif; ?> value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">Phone</label>
                                                <input type="text" value="<?= @$customerData->userDetails->mobile ?>" class="form-control" name="mobile_no" placeholder="Mobile No">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">Trial Class</label>
                                                <input type="number" value="<?= @$customerData->studentOptions->count_trial_sessions ?>" class="form-control" name="count_trial_sessions" placeholder="No of first free session">
                                            </div>
                                        </div>
                                         <div class="col-md-6 <?php if ($customerData->studentOptions->has_gift_sessions != 1): echo "hidden";endif;?> " id="is-show-for-assign-free-seaaion">
                                            <div class="form-group">
                                                <label for="projectinput3">No of free sessions</label>
                                                <input type="number" value="<?=@$customerData->studentOptions->count_gift_sessions?>" class="form-control" id="count-gift-sessions" name="count_gift_sessions" placeholder="No of free session">
                                            </div>
                                        </div>
                                        <div class="col-md-6 <?php if ($customerData->studentOptions->has_recurring_gift_sessions != 1): echo "hidden";endif;?>" id="is-show-for-assign-free-recurrint-seaaion">
                                            <div class="form-group">
                                                <label for="projectinput3">No of free recurring Sessions</label>
                                                <input type="number" value="<?=@$customerData->studentOptions->count_recurring_gift_sessions?>" class="form-control" id="count-recurring-gift-sessions" name="count_recurring_gift_sessions" placeholder="No of free session">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <label for="projectinput3">Company</label><br>
                                            <select class="form-control select2" name="company_id" style="height: calc(2.25rem + 10px);">
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ $company->id == $customerData->studentOptions->company_id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 <?php if ($customerData->studentOptions->has_free_sessions_for_company != 1): echo "hidden"; endif;?>"   id="is-show-for-assign-free-seaaion-for-company">
                                            <div class="form-group">
                                                <label for="projectinput3">No of free sessions for company</label>
                                                <input type="number" value="<?= $customerData->studentOptions->count_company_sessions ?? '0' ?>" class="form-control" id="no-of-assign-free-session-for-company" name="count_company_sessions" placeholder="No of free session For Company">
                                            </div>
                                        </div>
                                        <div class="col-md-6 @if($customerData->studentOptions->has_free_recurring_sessions_for_company != 1) hidden @endif" id="company_package_frequncy_for_company">
                                            <label for="projectinput3">Package</label><br>
                                            <select class="form-control select2" name="plan_id" style="height: calc(2.25rem + 10px);width:100%;">
                                                <option value="">Select Package</option>
                                                @foreach($plans as $plan)
                                                    <option value="{{ $plan->id }}"
                                                            @if(isset($customerData->companySubscription->plan->id) && $customerData->companySubscription->plan->id == $plan->id) selected @endif>
                                                        {{ $plan->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 <?php if ($customerData->studentOptions->has_free_recurring_sessions_for_company != 1): echo "hidden"; endif;?>"  id="company_package_start_date_for_company">
                                            <label for="projectinput3">Package Start Date</label><br>
                                            {{--//ToDo: Implement start date of subscription --}}
                                            <select class="form-control select2 " name="company_recurring_package_start_date" style="height: calc(2.25rem + 10px);width:100%;" >
                                                <option value="">Select Date</option>
                                                <?php for($i = 1; $i <= 30; $i++): ?>
                                                <option value="<?= $i; ?>" <?php if(@$customerData->company_select_day == $i): echo 'selected'; endif; ?> ><?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gift Class</label>
                                                <br>
                                                <span class="text-danger">Deactive</span>&nbsp;&nbsp;<input type="checkbox" id="assign-free-session" class="switchery" data-size="sm" <?php if ($customerData->studentOptions->has_gift_sessions == 1): echo "checked";endif;?>/>&nbsp;&nbsp;<span class="text-success">Active</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Monthly Recurring Free Session</label>
                                                <br>
                                                <span class="text-danger">Paid</span>&nbsp;&nbsp;<input type="checkbox" id="assign-free-recurring-session" class="switchery" data-size="sm" <?php if ($customerData->studentOptions->has_recurring_gift_sessions == 1): echo "checked";endif;?>/>&nbsp;&nbsp;<span class="text-success">Free</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>User Status</label>
                                                <br>
                                                <span class="text-danger">Deactive</span>&nbsp;&nbsp;<input type="checkbox" id="customer-status" class="switchery" data-size="sm" <?php if($customerData->is_active == 1): echo "checked";  endif; ?>/>&nbsp;&nbsp;<span class="text-success">Active</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Session Status</label>
                                                <br>
                                                <span class="text-danger">Paid</span>&nbsp;&nbsp;<input type="checkbox" id="session-status" class="switchery" data-size="sm" <?php if($customerData->studentOptions->has_free_unlimited_sessions == 1): echo "checked";  endif; ?>/>&nbsp;&nbsp;<span class="text-success">Free</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Notification Status</label>
                                                <br>
                                                <span class="text-danger">Deactive</span>&nbsp;&nbsp;<input type="checkbox" id="is-email-notification-on" class="switchery" data-size="sm" <?php if($customerData->studentOptions->has_email_notification == 1): echo "checked";  endif; ?>/>&nbsp;&nbsp;<span class="text-success">Active</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label>Company Limited Sessions</label>
                                                <br>
                                                <span class="text-danger">OFF</span>&nbsp;&nbsp;<input type="checkbox" id="company-session-status" class="switchery assign-free-session-for-company" data-size="sm" <?php if($customerData->studentOptions->has_free_sessions_for_company == 1): echo "checked";  endif; ?>/>&nbsp;&nbsp;<span class="text-success">ON</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label>Company Recurring Sessions</label>
                                                <br>
                                                <span class="text-danger">OFF</span>&nbsp;&nbsp;<input type="checkbox" id="company-session-status-for-recurring" class="switchery assign-free-session-for-company-for-recurring" data-size="sm" <?php if($customerData->studentOptions->has_free_recurring_sessions_for_company == 1): echo "checked";  endif; ?>/>&nbsp;&nbsp;<span class="text-success">ON</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?= @$customerData->id ?>" class="form-control" placeholder="Customer Id" name="customer_id">
                                <div class="form-actions">
                                    <button type="submit" id="customer-info-update-processing" class="btn btn-primary">
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
