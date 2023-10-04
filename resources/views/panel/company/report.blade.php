@extends('layouts.admin_layout')
@section('content')  
<div class="content-body">
    <section id="configuration">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Company Session Report</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="company_session_count_submit">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="projectinput3">Select teacher</label><br>
                                            <select class="form-control select2" name="selected_company_name"  style="height: calc(2.25rem + 10px);" onchange="getCurrentSelectedCompany(this.value)" required>
                                                <option value="">Select company</option>
                                                <?php foreach ($companies as $companie):  ?>
                                                    <option value="<?= $companie->id ?>"><?= $companie->company_name ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Select From Date</label>
                                                <input type="text" value="" id="select_from_date_for_pay_scale" class="form-control datepicker date" data-provide="datepicker" placeholder="Select From Date" name="select_company_session_from_date" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Select To Date</label>
                                                <input type="text" value="" id="select_to_date_for_pay_scale" class="form-control datepicker date" data-provide="datepicker" placeholder="Select To Date" name="select_company_session_to_date" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 hidden">
                                    <div class="form-group">
                                        <label for="projectinput2">Select To Date</label>
                                        <input type="hidden" value="" id="get-current-selected-company-id" class="form-control" name="current_selected_company_id" readonly required>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="company-session-count-processing" class="btn btn-primary">
                                        Search
                                    </button>
                                    &nbsp;
                                    <button type="button" id="export-to-student-company-data-report-to-excel" class="btn btn-primary" style="margin-left:15px;">
                                        Export to Excel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 border-right-grey border-right-lighten-3 clearfix">
                                    <div class="float-left pl-2">
                                        <span class="grey darken-1 block">Completed Sessions</span>
                                        <span class="font-large-3 line-height-1 text-bold-300"><span id="company-total-completed-sessions">0</span></span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 border-right-grey border-right-lighten-3 clearfix">
                                    <div class="float-left pl-2">
                                        <span class="grey darken-1 block">Missed Sessions</span>
                                        <span class="font-large-3 line-height-1 text-bold-300"><span id="company-total-missed-sessions">0</span></span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 border-right-grey border-right-lighten-3 clearfix">
                                    <div class="float-left pl-2">
                                        <span class="grey darken-1 block">Cancelled Sessions</span>
                                        <span class="font-large-3 line-height-1 text-bold-300"><span id="company-total-cancelled-sessions">0</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card hidden">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 border-right-grey border-right-lighten-3 clearfix">
                                    <div class="float-left pl-2">
                                        <span class="grey darken-1 block">Total Students</span>
                                        <span class="font-large-3 line-height-1 text-bold-300"><span id="company-total-student-who-attempted">0</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--<h4 class="card-title">Customers List - (<b id="customerTotalRecords">0</b>)</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <table id="company-students-lists-datatable" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <?php if (getCurrentAdminUserData()->admin_type == 'ADMIN'): ?>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        <?php endif; ?>
                                        <th>Completed Session</th>
                                        <th>Missed Sessions</th>
                                        <th>Cancelled Sessions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
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