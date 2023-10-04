@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="min-height: 720px;">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Availabilities Info <b><?= $teacher->first_name.' '.$teacher->last_name ?></b></h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body" style="overflow: auto;">
                            <form class="form" id="edit_coach_availabilities_submit">
                                <div class="form-body" style="width: 1080px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered text-center" style="width:1080px;">
                                                <thead>
                                                <tr>
                                                    <th>Days</th>
                                                    <th>Availability</th>
                                                    <th>Opening Time</th>
                                                    <th>Closing Time</th>
                                                    <th>Force Change</th>
                                                    <th>Break Start Time</th>
                                                    <th>Break end Time</th>
                                                    <th>Clear Break Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Monday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['day'] : 'monday' ?>" name="availabilities[monday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['id'] : null ?>" name="availabilities[monday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="MondayStatus" class="switchery" <?php if (isset($availabilities['monday']) && $availabilities['monday']['is_available'] == 1): ?> checked <?php endif; ?> data-size="sm" />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_monday_time" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['from_time'] : null ?>" class="form-control"  name="availabilities[monday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_monday_time" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['to_time'] : null ?>" class="form-control" name="availabilities[monday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="MondayChangeStatus" class="switchery" data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_monday_time" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['break_from_time'] : null ?>" class="form-control"  name="availabilities[monday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_monday_time" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['break_to_time'] : null ?>" class="form-control" name="availabilities[monday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="checkbox" value="" id="clear_monday_break_time">
                                                                <input type="hidden" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['break_from_time'] : null ?>" id="get_monday_old_break_start_time">
                                                                <input type="hidden" value="<?= isset($availabilities['monday']) ? $availabilities['monday']['break_to_time'] : null ?>" id="get_monday_old_break_end_time">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tuesday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['day'] : 'tuesday' ?>" name="availabilities[tuesday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['id'] : null ?>" name="availabilities[tuesday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="TuesdayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['tuesday']) && $availabilities['tuesday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_tuesday_time" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['from_time'] : null ?>" class="form-control" name="availabilities[tuesday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_tuesday_time" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['to_time'] : null ?>" class="form-control" name="availabilities[tuesday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="TuesdayChangeStatus" class="switchery" data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_tuesday_time" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['break_from_time'] : null ?>" class="form-control" name="availabilities[tuesday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_tuesday_time" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['break_to_time'] : null ?>" class="form-control" name="availabilities[tuesday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_tuesday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['break_from_time'] : null ?>" id="get_tuesday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['tuesday']) ? $availabilities['tuesday']['break_to_time'] : null ?>" id="get_tuesday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Wednesday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['day'] : 'wednesday' ?>" name="availabilities[wednesday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['id'] : null ?>" name="availabilities[wednesday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="WednesdayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['wednesday']) && $availabilities['wednesday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_wednesday_time" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['from_time'] : null ?>" class="form-control" name="availabilities[wednesday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_wednesday_time" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['to_time'] : null ?>" class="form-control" name="availabilities[wednesday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="WednesdayChangeStatus" class="switchery" data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_wednesday_time" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['break_from_time'] : null ?>" class="form-control" name="availabilities[wednesday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_wednesday_time" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['break_to_time'] : null ?>" class="form-control" name="availabilities[wednesday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_wednesday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['break_from_time'] : null ?>" id="get_wednesday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['wednesday']) ? $availabilities['wednesday']['break_to_time'] : null ?>" id="get_wednesday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Thursday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['day'] : 'thursday' ?>" name="availabilities[thursday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['id'] : null ?>" name="availabilities[thursday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="ThursdayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['thursday']) && $availabilities['thursday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_thursday_time" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['from_time'] : null ?>" class="form-control" name="availabilities[thursday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_thursday_time" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['to_time'] : null ?>" class="form-control" name="availabilities[thursday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="ThursdayChangeStatus" class="switchery" data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_thursday_time" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['break_from_time'] : null ?>" class="form-control" name="availabilities[thursday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_thursday_time" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['break_to_time'] : null ?>" class="form-control" name="availabilities[thursday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_thursday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['break_from_time'] : null ?>" id="get_thursday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['thursday']) ? $availabilities['thursday']['break_to_time'] : null ?>" id="get_thursday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Friday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['day'] : 'friday' ?>" name="availabilities[friday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['id'] : null ?>" name="availabilities[friday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="FridayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['friday']) && $availabilities['friday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_friday_time" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['from_time'] : null ?>" class="form-control" name="availabilities[friday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_friday_time" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['to_time'] : null ?>" class="form-control" name="availabilities[friday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="FridayChangeStatus" class="switchery"  data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_friday_time" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['break_from_time'] : null ?>" class="form-control" name="availabilities[friday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_friday_time" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['break_to_time'] : null ?>" class="form-control" name="availabilities[friday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_friday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['break_from_time'] : null ?>" id="get_friday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['friday']) ? $availabilities['friday']['break_to_time'] : null ?>" id="get_friday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Saturday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['day'] : 'saturday' ?>" name="availabilities[saturday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['id'] : null ?>" name="availabilities[saturday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="SaturdayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['saturday']) && $availabilities['saturday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_saturday_time" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['from_time'] : null ?>" class="form-control" name="availabilities[saturday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_saturday_time" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['to_time'] : null ?>" class="form-control" name="availabilities[saturday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="SaturdayChangeStatus" class="switchery" data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_saturday_time" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['break_from_time'] : null ?>" class="form-control" name="availabilities[saturday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_saturday_time" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['break_to_time'] : null ?>" class="form-control" name="availabilities[saturday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_saturday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['break_from_time'] : null ?>" id="get_saturday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['saturday']) ? $availabilities['saturday']['break_to_time'] : null ?>" id="get_saturday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sunday</td>
                                                    <input type="hidden" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['day'] : 'sunday' ?>" name="availabilities[sunday][day]">
                                                    <input type="hidden" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['id'] : null ?>" name="availabilities[sunday][id]">
                                                    <td>
                                                        <span class="text-danger">Close</span>&nbsp;&nbsp;<input type="checkbox" id="SundayStatus" class="switchery" data-size="sm" <?php if (isset($availabilities['sunday']) && $availabilities['sunday']['is_available'] == 1): ?> checked <?php endif; ?> />&nbsp;&nbsp;<span class="text-success">Open</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_sunday_time" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['from_time'] : null ?>" class="form-control" name="availabilities[sunday][from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_sunday_time" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['to_time'] : null ?>" class="form-control" name="availabilities[sunday][to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">No</span>&nbsp;&nbsp;<input type="checkbox" id="SundayChangeStatus" class="switchery"  data-size="sm" />&nbsp;&nbsp;<span class="text-success">Yes</span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="open_break_sunday_time" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['break_from_time'] : null ?>" class="form-control" name="availabilities[sunday][break_from_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <fieldset class="form-group">
                                                                <input type="time" id="close_break_sunday_time" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['break_to_time'] : null ?>" class="form-control" name="availabilities[sunday][break_to_time]">
                                                            </fieldset>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="skin skin-square">
                                                                    <input type="checkbox" value="" id="clear_sunday_break_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['break_from_time'] : null ?>" id="get_sunday_old_break_start_time">
                                                                    <input type="hidden" value="<?= isset($availabilities['sunday']) ? $availabilities['sunday']['break_to_time'] : null ?>" id="get_sunday_old_break_end_time">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?= $teacher->id ?>" class="form-control" placeholder="Customer Id" name="customer_id">
                                <div class="form-actions">
                                    <button type="submit" id="coach-availabilities-info-update-processing" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Change Availability</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="edit_coach_custom_availabilities_submit">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectinput1">Select Date</label>
                                                <input type="text" id="custom_date_time_selector" value="" class="form-control datepicker date" data-provide="datepicker" placeholder="Select Date" name="date" readonly required>
                                                <div id="datetimepicker_holidays_list" class="hidden">
                                                    <!--?= json_encode($selectedDate); ?>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="projectinput1">Start Time</label>
                                                    <fieldset class="form-group">
                                                        <input type="time" id="start_custome_date_time" value="" class="form-control" name="from_time" >
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="projectinput1">End Time</label>
                                                    <fieldset class="form-group">
                                                        <input type="time" id="end_custome_date_time" value="" class="form-control" name="to_time">
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="projectinput1">Break Start Time</label>
                                                    <fieldset class="form-group">
                                                        <input type="time" id="break_start_custome_date_time" value="" class="form-control" name="break_from_time" >
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="projectinput1">Break End Time</label>
                                                    <fieldset class="form-group">
                                                        <input type="time" id="break_end_custome_date_time" value="" class="form-control" name="break_to_time" >
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?= $teacher->id ?>" class="form-control" placeholder="Customer Id" name="teacher_id">
                                <div class="form-actions">
                                    <button type="submit" id="coach-custom-availabilities-info-update-processing" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
            </div>
        </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Holidays Info</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="edit_coach_holidays_submit">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectinput1">Select Date</label>
                                                <input type="text" id="datetimepicker_holidays" value="" class="form-control datepicker date" data-provide="datepicker" placeholder="Select Date" name="date" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?= $teacher->id ?>" class="form-control" placeholder="Customer Id" name="teacher_id">
                                <div class="form-actions">
                                    <button type="submit" id="coach-holidays-info-update-processing" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card" style="min-height: 890px;">
                    <div class="card-header">
                        <h4 class="card-title">Holidays Info</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <div id="calendar_holidays_list" class="hidden">
                                <?= json_encode($holidays); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body" style="overflow: auto;">
                            <div id='fc-default'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Day wise time List</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <table id="appointment-lists-datatable" class="table table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>#SR.No</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Break Start Time</th>
                                    <th>Break End Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                <?php if($availabilityExceptions): ?>
                                    <?php foreach ($availabilityExceptions as $availabilityException): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $availabilityException['date'] ?></td>
                                    <td><?= $availabilityException['from_time'] ?? '-' ?></td>
                                    <td><?= $availabilityException['to_time'] ?? '-' ?></td>
                                    <td><?= $availabilityException['break_from_time'] ?? '-' ?></td>
                                    <td><?= $availabilityException['break_to_time'] ?? '-' ?></td>
                                    <td>
                                        <a href="JavaScript:Void(0);" onclick="editCustomAvailabilities('<?=  $availabilityException['teacher_id']; ?>','<?= $availabilityException['date'] ?>','<?= $availabilityException['from_time'] ?? null ?>','<?= $availabilityException['to_time'] ?? null ?>','<?= $availabilityException['break_from_time'] ?? null ?>','<?= $availabilityException['break_to_time'] ?? null ?>')"  class="text-primary" data-toggle="modal" data-target="#changeCustomAvailabilitiesModal"><i class="ft-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="JavaScript:Void(0);" onclick="deleteCustomAvailabilities('<?=  $availabilityException['teacher_id']; ?>','<?= $availabilityException['date'] ?>')" class="text-primary"><i class="ft-trash"></i>&nbsp;&nbsp; Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade text-left" id="changeCustomAvailabilitiesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" id="edit_coach_custom_availabilities_submit_change_time">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Edit Avalibility</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Date</label>
                                                    <input type="text" id="edit_custom_date_time_selector" value="" class="form-control" placeholder="Select Date" name="date" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Start Time</label>
                                                        <fieldset class="form-group">
                                                            <input type="time" id="edit_start_custome_date_time" value="" class="form-control" name="from_time">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="projectinput1">End Time</label>
                                                        <fieldset class="form-group">
                                                            <input type="time" id="edit_end_custome_date_time" value="" class="form-control" name="to_time">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Break Start Time</label>
                                                        <fieldset class="form-group">
                                                            <input type="time" id="edit_break_start_custome_date_time" value="" class="form-control" name="break_from_time" >
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="projectinput1">Break End Time</label>
                                                        <fieldset class="form-group">
                                                            <input type="time" id="edit_break_end_custome_date_time" value="" class="form-control" name="break_to_time" >
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?= $teacher->id ?>" class="form-control" placeholder="Customer Id" id="edit_custom_date_time_customer_id" name="teacher_id">
                                    <input type="hidden" value="" class="form-control" placeholder="Time Change ID" id="edit_custom_date_time_holiday_id" name="edit_custom_date_time_holiday_id">
                                    <input type="hidden" value="" class="form-control" placeholder="Entry Type" id="edit_custom_date_entry_type" name="edit_custom_date_entry_type">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">.
                    <button type="submit" id="'#edit-coach-custom-availabilities-info-update-processing'" class="btn btn-primary">
                        Update
                    </button>
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
