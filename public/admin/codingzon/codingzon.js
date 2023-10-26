/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#assign-free-session').on('change', function (event) {
    event.preventDefault();

    var assignSweetStatus;
    if ($('#assign-free-session').prop("checked") == true) {
        assignSweetStatus = '1';
    } else if ($('#assign-free-session').prop("checked") == false) {
        assignSweetStatus = '0';
    }

    if (assignSweetStatus !== '1') {
        $('#no-of-assign-free-session').val(0);
        $('#is-show-for-assign-free-seaaion').addClass('hidden');
    } else {
        $('#is-show-for-assign-free-seaaion').removeClass('hidden');
    }

    // alert(assignSweetStatus);
    // return;

});

$('#assign-free-recurring-session').on('change', function (event) {
    event.preventDefault();

    var assignRecurringSweetStatus;
    if ($('#assign-free-recurring-session').prop("checked") == true) {
        assignRecurringSweetStatus = '1';
    } else if ($('#assign-free-recurring-session').prop("checked") == false) {
        assignRecurringSweetStatus = '0';
    }

    if (assignRecurringSweetStatus !== '1') {
        $('#no-of-assign-free-recurring-session').val(0);
        $('#is-show-for-assign-free-recurrint-seaaion').addClass('hidden');
    } else {
        $('#is-show-for-assign-free-recurrint-seaaion').removeClass('hidden');
    }


});

// START ARTICAL

$('#submit_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("add_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/artical/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-artical-to-student-processing').attr("disabled", true);
            $('#save-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-artical-to-student-processing').attr("disabled", false);
            $('#save-artical-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-artical-to-student-processing').attr("disabled", false);
            $('#save-artical-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("edit_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/artical/editArtical',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-artical-to-student-processing').attr("disabled", true);
            $('#edit-save-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-artical-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-artical-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var articalDatatabele = $('#artical-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteArtical(articalId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover article!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/artical/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'articalId': articalId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END ARTICAL

// START GRAMMER

$('#submit_grammer_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("add_grammer_details").getContent();
    formData.append('grammer_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/grammar/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-grammer-to-student-processing').attr("disabled", true);
            $('#save-grammer-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-grammer-to-student-processing').attr("disabled", false);
            $('#save-grammer-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-grammer-to-student-processing').attr("disabled", false);
            $('#save-grammer-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_grammer_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("edit_grammer_details").getContent();
    formData.append('grammer_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/grammar/editGrammar',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-grammer-to-student-processing').attr("disabled", true);
            $('#edit-save-grammer-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-grammer-to-student-processing').attr("disabled", false);
            $('#edit-save-grammer-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-grammer-to-student-processing').attr("disabled", false);
            $('#edit-save-grammer-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var grammerDatatabele = $('#grammer-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteGrammar(grammarId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover Grammar!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/grammar/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'grammarId': grammarId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END GRAMMER

$('#teacher_payscal_count_submit').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/payScale/findPayScaleCount',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#teacher-info-pay-scale-count-processing').attr("disabled", true);
            $('#teacher-info-pay-scale-count-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Searching..!');
        },
        success: function (response) {
            $('#teacher-info-pay-scale-count-processing').attr("disabled", false);
            $('#teacher-info-pay-scale-count-processing').html('Search');
            jsonData = JSON.parse(response);
            $('#teacher-total-completed-sessions').text(jsonData.data.completedCount);
            $('#teacher-total-missed-sessions').text(jsonData.data.missedCount);
            $('#teacher-total-both-sessions').text(jsonData.data.totalSessionCount);
            $('#teacher-start-working-date').text(jsonData.data.startWorkingDate);

            $('#teacher-total-good-report').text(jsonData.data.goodReport);
            $('#teacher-total-close-deal').text(jsonData.data.closeDeal);
            $('#teacher-total-close-and-good-report-incentive').text(jsonData.data.totalIncentive);

            $('#teacher-total-close-deal-amount').text(jsonData.data.totalCloseDealAmount);
            $('#teacher-total-good-report-amount').text(jsonData.data.totalGoodReportAmount);

        },
        error: function (data) {
            $('#teacher-info-pay-scale-count-processing').attr("disabled", false);
            $('#teacher-info-pay-scale-count-processing').html('Search');
            toastr.error("Error!");
        }
    });
});

$('#analytics_for_close_deal_submit').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/analytics/findAnalyticsCount',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#teacher-info-analytics-for-close-deal-processing').attr("disabled", true);
            $('#teacher-info-analytics-for-close-deal-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Searching..!');
        },
        success: function (response) {
            $('#teacher-info-analytics-for-close-deal-processing').attr("disabled", false);
            $('#teacher-info-analytics-for-close-deal-processing').html('Search');
            jsonData = JSON.parse(response);

            // MORNING
            $('#get-date-wise-analitics-percentage-for-close-deal').text(jsonData.data.totalCloseDeal);
            $('#get-date-wise-analitics-percentage-for-close-deal-completed-missed-session').text(jsonData.data.totalCloseDealCompletedANDMissed);
            $('#get-date-wise-analitics-percentage-for-close-deal-completed-missed-and-cancelled-session').text(jsonData.data.totalCloseDealCompletedANDMissedANDCancelled);


        },
        error: function (data) {
            $('#teacher-info-analytics-for-close-deal-processing').attr("disabled", false);
            $('#teacher-info-analytics-for-close-deal-processing').html('Search');
            toastr.error("Error!");
        }
    });
});


$('#teacher_payscal_count_submit_new').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/payScale/findPayScaleCount1',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#teacher-info-pay-scale-count-processing-new').attr("disabled", true);
            $('#teacher-info-pay-scale-count-processing-new').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Searching..!');
        },
        success: function (response) {
            $('#teacher-info-pay-scale-count-processing-new').attr("disabled", false);
            $('#teacher-info-pay-scale-count-processing-new').html('Search');
            jsonData = JSON.parse(response);

            // MORNING
            $('#teacher-total-completed-sessions-for-morning').text(jsonData.data.morningCompletedSessionCount);
            $('#teacher-total-missed-sessions-for-morning').text(jsonData.data.morningMissedSessionCount);
            $('#teacher-total-both-sessions-for-morning').text(jsonData.data.totalMorningSessionCount);

            // MORNING AMOUNT
            $('#teacher-total-completed-sessions-amount-for-morning').text(jsonData.data.morningCompletedSessionAmount);
            $('#teacher-total-missed-sessions-amount-for-morning').text(jsonData.data.morningMissedSessionAmount);
            $('#teacher-total-both-sessions-amount-for-morning').text(jsonData.data.totalMorningSessionAmount);

            // MORNING AMOUNT USD
            $('#teacher-total-completed-sessions-amount-for-morning-usd').text(jsonData.data.morningCompletedSessionAmountUSD);
            $('#teacher-total-missed-sessions-amount-for-morning-usd').text(jsonData.data.morningMissedSessionAmountUSD);
            $('#teacher-total-both-sessions-amount-for-morning-usd').text(jsonData.data.totalMorningSessionAmountUSD);


            // EVENING
            $('#teacher-total-completed-sessions-for-evening').text(jsonData.data.eveningCompletedSessionCount);
            $('#teacher-total-missed-sessions-for-evening').text(jsonData.data.eveningMissedSessionCount);
            $('#teacher-total-both-sessions-for-evening').text(jsonData.data.totalEveningSessionCount);


            // EVENING AMOUNT
            $('#teacher-total-completed-sessions-amount-for-evening').text(jsonData.data.eveningCompletedSessionAmount);
            $('#teacher-total-missed-sessions-amount-for-evening').text(jsonData.data.eveningMissedSessionAmount);
            $('#teacher-total-both-sessions-amount-for-evening').text(jsonData.data.totalEveningSessionAmount);


            // EVENING AMOUNT USD
            $('#teacher-total-completed-sessions-amount-for-evening-usd').text(jsonData.data.eveningCompletedSessionAmountUSD);
            $('#teacher-total-missed-sessions-amount-for-evening-usd').text(jsonData.data.eveningMissedSessionAmountUSD);
            $('#teacher-total-both-sessions-amount-for-evening-usd').text(jsonData.data.totalEveningSessionAmountUSD);


            // // NIGHT
            $('#teacher-total-completed-sessions-for-night').text(jsonData.data.nightCompletedSessionCount);
            $('#teacher-total-missed-sessions-for-night').text(jsonData.data.nightMissedSessionCount);
            $('#teacher-total-both-sessions-for-night').text(jsonData.data.totalNightSessionCount);


            // NIGHT AMOUNT
            $('#teacher-total-completed-sessions-amount-for-night').text(jsonData.data.nightCompletedSessionAmount);
            $('#teacher-total-missed-sessions-amount-for-night').text(jsonData.data.nightMissedSessionAmount);
            $('#teacher-total-both-sessions-amount-for-night').text(jsonData.data.totalNightSessionAmount);


            // NIGHT AMOUNT USD
            $('#teacher-total-completed-sessions-amount-for-night-usd').text(jsonData.data.nightCompletedSessionAmountUSD);
            $('#teacher-total-missed-sessions-amount-for-night-usd').text(jsonData.data.nightMissedSessionAmountUSD);
            $('#teacher-total-both-sessions-amount-for-night-usd').text(jsonData.data.totalNightSessionAmountUSD);


            $('#teacher-start-working-date').text(jsonData.data.startWorkingDate);

            $('#teacher-total-good-report').text(jsonData.data.goodReport);
            $('#teacher-total-close-deal').text(jsonData.data.closeDeal);
            $('#teacher-total-close-and-good-report-incentive').text(jsonData.data.totalIncentive);

            $('#teacher-total-close-deal-amount').text(jsonData.data.totalCloseDealAmount);
            $('#teacher-total-good-report-amount').text(jsonData.data.totalGoodReportAmount);
            $('#teacher-total-close-and-good-report-incentive-amount').text(jsonData.data.totalIncentiveAmount);


            $('#teacher-total-close-deal-amount-usd').text(jsonData.data.totalCloseDealAmountUSD);
            $('#teacher-total-good-report-amount-usd').text(jsonData.data.totalGoodReportAmountUSD);
            $('#teacher-total-close-and-good-report-incentive-amount-usd').text(jsonData.data.totalIncentiveAmountUSD);

            $('#total-of-all-pay-scale-amount').text(jsonData.data.totalOfAllAmount);
            $('#total-of-all-pay-scale-amount-usd').text(jsonData.data.totalOfAllAmountUSD);

        },
        error: function (data) {
            $('#teacher-info-pay-scale-count-processing-new').attr("disabled", false);
            $('#teacher-info-pay-scale-count-processing-new').html('Search');
            toastr.error("Error!");
        }
    });
});

$('#export-to-pay-scale-report-to-excel').on('click', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);
    formData.append('select_from_date', $('#select_from_date_for_pay_scale').val());
    formData.append('select_to_date', $('#select_to_date_for_pay_scale').val());

    var fromDate = $('#select_from_date_for_pay_scale').val();
    var toDate = $('#select_to_date_for_pay_scale').val();

    $('#export-to-pay-scale-report-to-excel').attr("disabled", true);
    $('#export-to-pay-scale-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/payScale/findPayScaleCountAndExport/?select_from_date=' + fromDate + '&select_to_date=' + toDate + '', '_blank');
    $('#export-to-pay-scale-report-to-excel').attr("disabled", false);
    $('#export-to-pay-scale-report-to-excel').html('Export to Excel');

//    $.ajax({
//        url: BaseURLForAdmin + '/payScale/findPayScaleCountAndExport',
//        data: formData,
//        type: 'POST',
//        cache: false,
//        processData: false,
//        contentType: false,
//        beforeSend: function () {
//
//        },
//        success: function (response) {
//            $('#export-to-pay-scale-report-to-excel').attr("disabled", false);
//            $('#export-to-pay-scale-report-to-excel').html('Export to Excel');
//            jsonData = JSON.parse(response);
//        },
//        error: function (data) {
//            $('#export-to-pay-scale-report-to-excel').attr("disabled", false);
//            $('#export-to-pay-scale-report-to-excel').html('Export to Excel');
//            toastr.error("Error!");
//        }
//    });
});

function getTeacherStartWork(teacherId) {

    $.ajax({
        url: BaseURLForAdmin + '/payScale/findTeacherStartWorkDate',
        type: 'POST',
        data: {
            '_token': csrf_token,
            'teacherId': teacherId
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            $('#teacher-start-working-date').text(jsonData.data.startWorkingDate);
        },
        error: function (data) {
            swal("Something went wrong!");
        }
    });

}

$('#edit_notification_submit').on('submit', function (event) {
    event.preventDefault();

    var sendToAllStudents;
    if ($('#yes-send-to-all-students').prop("checked") == true) {
        sendToAllStudents = '1';
    } else if ($('#yes-send-to-all-students').prop("checked") == false) {
        sendToAllStudents = '0';
    }

    var sendToAllTeachers;
    if ($('#yes-send-to-all-teachers').prop("checked") == true) {
        sendToAllTeachers = '1';
    } else if ($('#yes-send-to-all-teachers').prop("checked") == false) {
        sendToAllTeachers = '0';
    }


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('sendToAllStudents', sendToAllStudents);
    formData.append('sendToAllTeachers', sendToAllTeachers);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/notification/sendNotification',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#notification-info-update-processing').attr("disabled", true);
            $('#notification-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            $('#notification-info-update-processing').attr("disabled", false);
            $('#notification-info-update-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }
        },
        error: function (data) {
            $('#notification-info-update-processing').attr("disabled", false);
            $('#notification-info-update-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

$('#edit_coach_custom_all_session_transfer').on('submit', function (event) {
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "Make sure both teachers booking status needs to be stop temporary for transfer session.!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var formData = new FormData($(this).closest('form')[0]);
                formData.append('_token', csrf_token);

                $.ajax({
                    url: BaseURLForAdmin + '/coach/transferAllSessionForPerticularDays',
                    data: formData,
                    type: 'POST',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#coach-custom-session-transfer-info-update-processing').attr("disabled", true);
                        $('#coach-custom-session-transfer-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
                    },
                    success: function (response) {
                        $('#coach-custom-session-transfer-info-update-processing').attr("disabled", false);
                        $('#coach-custom-session-transfer-info-update-processing').html('Submit');
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            toastr.error(jsonData.message);
                        }
                    },
                    error: function (data) {
                        $('#coach-custom-session-transfer-info-update-processing').attr("disabled", false);
                        $('#coach-custom-session-transfer-info-update-processing').html('Submit');
                        toastr.error("Error!");
                    }
                });
            }
        });


});

function editCustomAvailabilities(teacherID, changeDate, start_time = null, end_time = null, break_start_time = null, break_end_time = null) {
    // $('#changeCustomAvailabilitiesModal').modal('show');
    $('#edit_custom_date_time_customer_id').val(teacherID);
    $('#edit_custom_date_time_selector').val(changeDate);
    $('#edit_start_custome_date_time').val(start_time);
    $('#edit_end_custome_date_time').val(end_time);
    $('#edit_break_start_custome_date_time').val(break_start_time);
    $('#edit_break_end_custome_date_time').val(break_end_time);
}

$('#edit_coach_custom_availabilities_submit_change_time').on('submit', function (event) {
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "Once change, you will not be able to recover booked sessions!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var formData = new FormData($(this).closest('form')[0]);
                formData.append('_token', csrf_token);

                $.ajax({
                    url: `${BaseURL}/teacher/availabilities/exceptions`,
                    data: formData,
                    type: 'POST',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#edit-coach-custom-availabilities-info-update-processing').attr("disabled", true);
                        $('#edit-coach-custom-availabilities-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
                    },
                    success: function (response) {
                        $('#edit-coach-custom-availabilities-info-update-processing').attr("disabled", false);
                        $('#edit-coach-custom-availabilities-info-update-processing').html('Update');
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            toastr.error(jsonData.message);
                        }
                    },
                    error: function (data) {
                        $('#edit-coach-custom-availabilities-info-update-processing').attr("disabled", false);
                        $('#edit-coach-custom-availabilities-info-update-processing').html('Update');
                        const errorData = JSON.parse(data.responseText);

                        let message
                        if (errorData.error != undefined) {
                            message = errorData.error;
                        } else if (errorData.message != undefined) {
                            message = errorData.message;
                        } else {
                            message = '';
                        }

                        toastr.error("Error! " + message);
                    }
                });
            }
        });

});

$('#edit_coach_custom_availabilities_submit').on('submit', function (event) {
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "Once change, you will not be able to recover booked sessions!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var formData = new FormData($(this).closest('form')[0]);
                formData.append('_token', csrf_token);

                $.ajax({
                    url: `${BaseURL}/teacher/availabilities/exceptions`,
                    data: formData,
                    type: 'POST',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#coach-custom-availabilities-info-update-processing').attr("disabled", true);
                        $('#coach-custom-availabilities-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
                    },
                    success: function (response) {
                        $('#coach-custom-availabilities-info-update-processing').attr("disabled", false);
                        $('#coach-custom-availabilities-info-update-processing').html('Update');
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            toastr.error(jsonData.message);
                        }
                    },
                    error: function (data) {
                        $('#coach-custom-availabilities-info-update-processing').attr("disabled", false);
                        $('#coach-custom-availabilities-info-update-processing').html('Update');
                        const errorData = JSON.parse(data.responseText);

                        let message
                        if (errorData.error != undefined) {
                            message = errorData.error;
                        } else if (errorData.message != undefined) {
                            message = errorData.message;
                        } else {
                            message = '';
                        }

                        toastr.error("Error! " + message);
                    }
                });
            }
        });


});
function deleteTeacher(teacherId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover teacher!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `${BaseURL}/teachers/${teacherId}`,
                    type: 'DELETE',
                    data: {
                        '_token': csrf_token,
                        'customerId': teacherId
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });
}

$('#update-teacher').on('click', function (event) {
    const teacherId = $('#teacher-id').val();
    const verificationStatus = $('#user-verification-status').val();
    const isActive = $('#is-active').prop("checked") ? 1 : 0;
    const canBeBooked = $('#can-be-booked').prop("checked") ? 1 : 0;
    const allowsTrial = $('#allows-trial').prop("checked") ? 1 : 0;

    $.ajax({
        url: `${BaseURL}/teacher-details/${teacherId}`,
        data: {
            "verification_status": verificationStatus,
            "is_active": isActive,
            "can_be_booked": canBeBooked,
            "allows_trial": allowsTrial,
            "_token": csrf_token,
        },
        type: 'PUT',
        cache: false,
        beforeSend: function () {
            swal({
                title: "Loading...",
                text: "Please wait",
                button: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        },
        success: function (response) {
            swal({
                title: "Success!",
                icon: "success",
                button: "Ok",
            });
            setInterval(function () {
                window.location.href = `${BaseURL}/teacher-details/${teacherId}`;
            }, 2000);
        },
        error: function (response) {
            toastr.error("Something went wrong!");
        }
    });
});

function deleteCustomAvailabilities(teacherId, date) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover sessions!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `${BaseURL}/teacher/availabilities/exceptions/delete`,
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'teacher_id': teacherId,
                        'date': date
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

$('#session_transfer_submit').on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/appointments/transferSession',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#session-transfer-processing').attr("disabled", true);
            $('#session-transfer-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#session-transfer-processing').attr("disabled", false);
            $('#session-transfer-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }
        },
        error: function (data) {
            $('#session-transfer-processing').attr("disabled", false);
            $('#session-transfer-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#conducted_session_to_teacher_submit').on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/appointments/payScaleConductedTeacherAssign',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#conducted-session-teacher-processing').attr("disabled", true);
            $('#conducted-session-teacher-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#conducted-session-teacher-processing').attr("disabled", false);
            $('#conducted-session-teacher-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }
        },
        error: function (data) {
            $('#conducted-session-teacher-processing').attr("disabled", false);
            $('#conducted-session-teacher-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_coach_holidays_submit').on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: `${BaseURL}/teacher/availability/holidays`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#coach-holidays-info-update-processing').attr("disabled", true);
            $('#coach-holidays-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            $('#coach-holidays-info-update-processing').attr("disabled", false);
            $('#coach-holidays-info-update-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#coach-holidays-info-update-processing').attr("disabled", false);
            $('#coach-holidays-info-update-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

$('#edit_coach_availabilities_submit').on('submit', function (event) {
    event.preventDefault();

    var MondayStatus;
    if ($('#MondayStatus').prop("checked") == true) {
        MondayStatus = '1';
    } else if ($('#MondayStatus').prop("checked") == false) {
        MondayStatus = '0';
    }

    var TuesdayStatus;
    if ($('#TuesdayStatus').prop("checked") == true) {
        TuesdayStatus = '1';
    } else if ($('#TuesdayStatus').prop("checked") == false) {
        TuesdayStatus = '0';
    }

    var WednesdayStatus;
    if ($('#WednesdayStatus').prop("checked") == true) {
        WednesdayStatus = '1';
    } else if ($('#WednesdayStatus').prop("checked") == false) {
        WednesdayStatus = '0';
    }

    var ThursdayStatus;
    if ($('#ThursdayStatus').prop("checked") == true) {
        ThursdayStatus = '1';
    } else if ($('#ThursdayStatus').prop("checked") == false) {
        ThursdayStatus = '0';
    }

    var FridayStatus;
    if ($('#FridayStatus').prop("checked") == true) {
        FridayStatus = '1';
    } else if ($('#FridayStatus').prop("checked") == false) {
        FridayStatus = '0';
    }

    var SaturdayStatus;
    if ($('#SaturdayStatus').prop("checked") == true) {
        SaturdayStatus = '1';
    } else if ($('#SaturdayStatus').prop("checked") == false) {
        SaturdayStatus = '0';
    }

    var SundayStatus;
    if ($('#SundayStatus').prop("checked") == true) {
        SundayStatus = '1';
    } else if ($('#SundayStatus').prop("checked") == false) {
        SundayStatus = '0';
    }

    // CHANGE TIME CODE
    var MondayChangeStatus;
    if ($('#MondayChangeStatus').prop("checked") == true) {
        MondayChangeStatus = '1';
    } else if ($('#MondayChangeStatus').prop("checked") == false) {
        MondayChangeStatus = '0';
    }

    var TuesdayChangeStatus;
    if ($('#TuesdayChangeStatus').prop("checked") == true) {
        TuesdayChangeStatus = '1';
    } else if ($('#TuesdayChangeStatus').prop("checked") == false) {
        TuesdayChangeStatus = '0';
    }

    var WednesdayChangeStatus;
    if ($('#WednesdayChangeStatus').prop("checked") == true) {
        WednesdayChangeStatus = '1';
    } else if ($('#WednesdayChangeStatus').prop("checked") == false) {
        WednesdayChangeStatus = '0';
    }

    var ThursdayChangeStatus;
    if ($('#ThursdayChangeStatus').prop("checked") == true) {
        ThursdayChangeStatus = '1';
    } else if ($('#ThursdayChangeStatus').prop("checked") == false) {
        ThursdayChangeStatus = '0';
    }

    var FridayChangeStatus;
    if ($('#FridayChangeStatus').prop("checked") == true) {
        FridayChangeStatus = '1';
    } else if ($('#FridayChangeStatus').prop("checked") == false) {
        FridayChangeStatus = '0';
    }

    var SaturdayChangeStatus;
    if ($('#SaturdayChangeStatus').prop("checked") == true) {
        SaturdayChangeStatus = '1';
    } else if ($('#SaturdayChangeStatus').prop("checked") == false) {
        SaturdayChangeStatus = '0';
    }

    var SundayChangeStatus;
    if ($('#SundayChangeStatus').prop("checked") == true) {
        SundayChangeStatus = '1';
    } else if ($('#SundayChangeStatus').prop("checked") == false) {
        SundayChangeStatus = '0';
    }


    var formData = new FormData($(this).closest('form')[0]);
    formData.append("availabilities[monday][is_available]", MondayStatus);
    formData.append("availabilities[tuesday][is_available]", TuesdayStatus);
    formData.append("availabilities[wednesday][is_available]", WednesdayStatus);
    formData.append("availabilities[thursday][is_available]", ThursdayStatus);
    formData.append("availabilities[friday][is_available]", FridayStatus);
    formData.append("availabilities[saturday][is_available]", SaturdayStatus);
    formData.append("availabilities[sunday][is_available]", SundayStatus);
    // CHANGE STATUS
    formData.append("availabilities[monday][force_change]", MondayChangeStatus);
    formData.append("availabilities[tuesday][force_change]", TuesdayChangeStatus);
    formData.append("availabilities[wednesday][force_change]", WednesdayChangeStatus);
    formData.append("availabilities[thursday][force_change]", ThursdayChangeStatus);
    formData.append("availabilities[friday][force_change]", FridayChangeStatus);
    formData.append("availabilities[saturday][force_change]", SaturdayChangeStatus);
    formData.append("availabilities[sunday][force_change]", SundayChangeStatus);
    formData.append('_token', csrf_token);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `${BaseURL}/teachers/${formData.get('customer_id')}/availabilities/edit`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#coach-availabilities-info-update-processing').attr("disabled", true);
            $('#coach-availabilities-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            console.log(response);
            $('#coach-availabilities-info-update-processing').attr("disabled", false);
            $('#coach-availabilities-info-update-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success(jsonData.message);
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#coach-availabilities-info-update-processing').attr("disabled", false);
            $('#coach-availabilities-info-update-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

$('#edit_customer_submit').on('submit', function (event) {
    event.preventDefault();

    var customerStatus;
    if ($('#customer-status').prop("checked") == true) {
        customerStatus = '1';
    } else if ($('#customer-status').prop("checked") == false) {
        customerStatus = '0';
    }

    var sessionStatus;
    if ($('#session-status').prop("checked") == true) {
        sessionStatus = '1';
    } else if ($('#session-status').prop("checked") == false) {
        sessionStatus = '0';
    }

    var assignSweetStatus;
    if ($('#assign-free-session').prop("checked") == true) {
        assignSweetStatus = '1';
    } else if ($('#assign-free-session').prop("checked") == false) {
        assignSweetStatus = '0';
    }

    var assignRecurringSweetStatus;
    if ($('#assign-free-recurring-session').prop("checked") == true) {
        assignRecurringSweetStatus = '1';
    } else if ($('#assign-free-recurring-session').prop("checked") == false) {
        assignRecurringSweetStatus = '0';
    }

    var UserEmailNotificationStatus;
    if ($('#is-email-notification-on').prop("checked") == true) {
        UserEmailNotificationStatus = '1';
    } else if ($('#is-email-notification-on').prop("checked") == false) {
        UserEmailNotificationStatus = '0';
    }

    var companySessionStatus;
    if ($('#company-session-status').prop("checked") == true) {
        companySessionStatus = '1';
    } else if ($('#company-session-status').prop("checked") == false) {
        companySessionStatus = '0';
    }

    var companyRecurringSessionStatus;
    if ($('#company-session-status-for-recurring').prop("checked") == true) {
        companyRecurringSessionStatus = '1';
    } else if ($('#company-session-status-for-recurring').prop("checked") == false) {
        companyRecurringSessionStatus = '0';
    }

    var formData = new FormData($(this).closest('form')[0]);

    formData.append('is_active', customerStatus);
    formData.append('has_free_unlimited_sessions', sessionStatus);

    formData.append('has_free_sessions_for_company', companySessionStatus);
    formData.append('has_free_recurring_sessions_for_company', companyRecurringSessionStatus);


    formData.append('has_gift_sessions', assignSweetStatus);
    formData.append('has_recurring_gift_sessions', assignRecurringSweetStatus);
    formData.append('has_email_notification', UserEmailNotificationStatus);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURL + '/student/update/'+formData.get('customer_id'),
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#customer-info-update-processing').attr("disabled", true);
            $('#customer-info-update-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            console.log(response)
            $('#customer-info-update-processing').attr("disabled", false);
            $('#customer-info-update-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    window.location.href = BaseURL + '/student';
                }, 3000);
            } else {
                toastr.error(jsonData.message);
            }
        },
        error: function (data) {
            $('#customer-info-update-processing').attr("disabled", false);
            $('#customer-info-update-processing').html('Update');
            try {
                const parsedData = JSON.parse(data.responseText);
                toastr.error(parsedData.message ?? "Error!");
            } catch (e) {
                toastr.error("Error!");
            }
        }
    });
});

function deleteCustomer(customerId) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this student!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURL + '/student/destroy/'+customerId,
                    type: 'DELETE',
                    data: {
                        '_token': csrf_token,
                        'customerId': customerId
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1500);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

var teacherDatatabele = $('#customer-lists-datatable-for-teacher').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});


// Run code
var cuatomerDatatabele = $('#customer-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "columns": [
        {
            "data": null,
            "defaultContent": "",
            "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { "data": "firstname" },
        { "data": "lastname" },
        { "data": "email" },
        { "data": "user_details.mobile" },
        {
            "data": "is_active",
            "render": function(data, type, row) {
                if (data) {
                        return `
                <span class="badge badge badge-success">Active</span>
                `;
                }
                return `
                 <span class="badge badge badge-success">Disabled</span>
                `;

            }
        },
        {
            "data": "created_at",
            "render": function(data, type, row) {
                return `
            -
            `;
            }
        },
        {
            "data": null,
            "render": function(data, type, row) {
                return `
            <a href="/student/edit/${data.id}" class="dropdown-item text-primary"><i class="ft-eye"></i>View Details</a>
            <a href="JavaScript:Void(0)" onclick="deleteCustomer(${data.id})" class="dropdown-item text-primary"><i class="ft-trash-2"></i> Delete</a></td>
            `;
            }
        }
    ],
    "ajax": {
        "url": `${BaseURL}/api/users?role=student`,
        "type": "GET",
        data: {_token: csrf_token},
        dataFilter: function (data) {
            var parsedData = JSON.parse(data);
            var users = parsedData["users"];
            var transformedData = {
                draw: 1,
                recordsTotal: users.length,
                recordsFiltered: users.length,
                data: users
            };

            console.log(transformedData)
            return JSON.stringify(transformedData);
        }
    }
});





var membershipDatatabele = $('#customer-membership-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

var studentNotScheduleTrialClassDatatabele = $('#customer-not-schedule-tiral-class-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

var membershipDatatabele = $('#customer-old-membership-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

var membershipDatatabele = $('#customer-membership-cancelled-reason-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

$('#edit_coach_submit').on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `${BaseURL}/teachers/${formData.get('id')}`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#coach-info-update-processing').attr("disabled", true);
            $('#coach-info-update-processing').html('<span style="color:#fff;"><i class="icon-refresh spinner"></i>&nbsp;&nbsp;Updating..!</span>');
        },
        success: function (response) {
            $('#coach-info-update-processing').attr("disabled", false);
            $('#coach-info-update-processing').html('Update');
            console.log(response);
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    window.location.href = `${BaseURL}/teachers/${formData.get('id')}`;
                }, 3000);
            } else {
                toastr.error(jsonData.message);
            }
        },
        error: function (data) {
            $('#coach-info-update-processing').attr("disabled", false);
            $('#coach-info-update-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

function deleteCoach(customerId) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this coach!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/coach/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'customerId': customerId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            cuatomerDatatabele.ajax.reload();
                            toastr.success("Success!");
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

var coachDatatabele = $('#coach-lists-datatable').DataTable({
    "responsive": true,
    "searching": true,
    "ordering": true,
});

function getSelectedValue(statusId) {
    var documentUserID = $('#document-user-id').val();


    $.ajax({
        url: BaseURLForAdmin + '/coach/changeDocumentStatus',
        data: {"documentUserID": documentUserID, "documentUserStatus": statusId, "_token": csrf_token},
        type: 'POST',
        cache: false,
        beforeSend: function () {
            swal({
                title: "Loading...",
                text: "Please wait",
                button: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                swal({
                    title: "Success!",
                    icon: "success",
                    button: "Ok",
                });
                setInterval(function () {
                    window.location.href = BaseURLForAdmin + '/coach';
                }, 2000);
            } else {
                toastr.error("Error!");
            }
        }
    });
}

$('#policy_submit').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    var content = tinymce.get("policyDetails").getContent();
    formData.append('_token', csrf_token);
    formData.append('policyDetails', content);

    $.ajax({
        url: BaseURLForAdmin + '/management/privacy-update',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#policy-processing').attr("disabled", true);
            $('#policy-processing').html('<i class="icon-spinner4 spinner mr-2"></i>&nbsp;&nbsp;Updating Policy');
        },
        success: function (response) {
            $('#policy-processing').attr("disabled", false);
            $('#policy-processing').html('Update Policy');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#policy-processing').attr("disabled", false);
            $('#policy-processing').html('Update Policy');
            toastr.error("Error!");
        }
    });
});

$('#terms_submit').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    var content = tinymce.get("termsAndConditions").getContent();
    formData.append('_token', csrf_token);
    formData.append('termsAndConditions', content);

    $.ajax({
        url: BaseURLForAdmin + '/management/terms-and-conditions-update',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#terms-processing').attr("disabled", true);
            $('#terms-processing').html('<i class="icon-spinner4 spinner mr-2"></i>&nbsp;&nbsp;Updating Terms Conditions');
        },
        success: function (response) {
            $('#terms-processing').attr("disabled", false);
            $('#terms-processing').html('Update Terms Conditions');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#terms-processing').attr("disabled", false);
            $('#terms-processing').html('Update Terms Conditions');
            toastr.error("Error!");
        }
    });
});

$('#shipping_charge_submit').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/management/add-costs-update',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#shipping-charge-processing').attr("disabled", true);
            $('#shipping-charge-processing').html('<i class="icon-spinner4 spinner mr-2"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            $('#shipping-charge-processing').attr("disabled", false);
            $('#shipping-charge-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#shipping-charge-processing').attr("disabled", false);
            $('#shipping-charge-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var appointmentDatatabele = $('#appointment-lists-datatable').DataTable({
    "responsive": true,
    "searching": true,
    "ordering": false
});

var pastDatatabele = $('#past-appointment-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/appointments/getAllPastSessions',
        "type": "POST",
        data: {_token: csrf_token, 'sessionType': $('#filter-by-session-type-in-all-past-seesions').val()},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

var cancelledWithReasonDatatabele = $('#cancelled-appointment-with-reason-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/appointments/getAllPastWithReasonSessions',
        "type": "POST",
        data: {_token: csrf_token,'countryCode': $('#get-country-code-for-filter-cancel-reason-appointment').val()},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

var upcommingDatatabele = $('#upcomming-view-appointment-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/appointments/getAllUpcommingSessions',
        "type": "POST",
        data: {_token: csrf_token},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

function cancelSession(sessionId) {
    swal({
        title: "Are you sure?",
        text: "Once canceled, you will not be able to recover this session!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/appointments/cancelSession',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'sessionId': sessionId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1500);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

$('#delete-review-of-teacher-for-admin').on('click', function (event) {

    var sessionId = $('#sessionIdForTeacherReview').val();


    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this review!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/appointments/deleteReview',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'sessionId': sessionId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            swal({
                                title: "Success!",
                                icon: "success",
                                button: "Ok",
                            }).then((value) => {
                                location.reload(true);
                            });
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });

});

$('#refund_client_payment_for_appointment').on('click', function (event) {
    event.preventDefault();

    var getAppointmentId = $('#appointment-id-for-refund').val();


    $.ajax({
        url: BaseURLForAdmin + '/appointments/refundPayment',
        data: {"appointmentId": getAppointmentId, "_token": csrf_token},
        type: 'POST',
        cache: false,
        beforeSend: function () {
            swal({
                title: "Loading...",
                text: "Please wait we are proceed your refund.",
                button: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                swal({
                    title: "Success!",
                    icon: "success",
                    button: "Ok",
                });
                setInterval(function () {
                    window.location.href = BaseURLForAdmin + '/appointments';
                }, 2000);
            } else {
                toastr.error("Error!");
            }
        }
    });
});


// START TO CLEAR TEACHER AVAILABILITIES BREAK TIME CLEAR CODE


$("#clear_monday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_monday_time').val("");
        $('#close_break_monday_time').val("");
    } else {
        $('#open_break_monday_time').val($('#get_monday_old_break_start_time').val());
        $('#close_break_monday_time').val($('#get_monday_old_break_end_time').val());
    }
});

$("#clear_tuesday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_tuesday_time').val("");
        $('#close_break_tuesday_time').val("");
    } else {
        $('#open_break_tuesday_time').val($('#get_tuesday_old_break_start_time').val());
        $('#close_break_tuesday_time').val($('#get_tuesday_old_break_end_time').val());
    }
});

$("#clear_wednesday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_wednesday_time').val("");
        $('#close_break_wednesday_time').val("");
    } else {
        $('#open_break_wednesday_time').val($('#get_wednesday_old_break_start_time').val());
        $('#close_break_wednesday_time').val($('#get_wednesday_old_break_end_time').val());
    }
});

$("#clear_thursday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_thursday_time').val("");
        $('#close_break_thursday_time').val("");
    } else {
        $('#open_break_thursday_time').val($('#get_thursday_old_break_start_time').val());
        $('#close_break_thursday_time').val($('#get_thursday_old_break_end_time').val());
    }
});

$("#clear_friday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_friday_time').val("");
        $('#close_break_friday_time').val("");
    } else {
        $('#open_break_friday_time').val($('#get_friday_old_break_start_time').val());
        $('#close_break_friday_time').val($('#get_friday_old_break_end_time').val());
    }
});

$("#clear_saturday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_saturday_time').val("");
        $('#close_break_saturday_time').val("");
    } else {
        $('#open_break_saturday_time').val($('#get_saturday_old_break_start_time').val());
        $('#close_break_saturday_time').val($('#get_saturday_old_break_end_time').val());
    }
});

$("#clear_sunday_break_time").click(function () {
    if ($(this).is(":checked")) {
        $('#open_break_sunday_time').val("");
        $('#close_break_sunday_time').val("");
    } else {
        $('#open_break_sunday_time').val($('#get_sunday_old_break_start_time').val());
        $('#close_break_sunday_time').val($('#get_sunday_old_break_end_time').val());
    }
});

function cancelMembership(customerId) {

    swal({
        title: "Are you sure?",
        text: "Once canceled, you will not be able to recover this membership!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/customers/cancelMembership',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'customerId': customerId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1500);
                        } else {
                            swal(jsonData.message);
                        }
                    },
                    error: function (data) {
                        // jsonData = JSON.parse(data);
                        swal(data.responseJSON.message);
                    }
                });
            }
        });


}

var unsubscribeCustomer = $('#customer-trial-session-and-didnt-subscribe-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/customers/getAllCustomersWhoUnsubscribed',
        "type": "POST",
        data: {_token: csrf_token, 'countryCode': $('#filter-by-country-code-unsubscribe-customer-datatable').val()},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

var hearAboutfalDatatabele = $('#hear-about-ifal-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

var everyMonthUsedSessions = $('#customer-lists-datatable-for-every-month-used').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/customers/getEveryMonthUsedSessions',
        "type": "POST",
        data: {_token: csrf_token, customerId: $('#monthly-used-membership-list-user-id').val()},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

function exportStudentDataReport(format) {

    $('#export-to-pay-scale-report-to-excel').attr("disabled", true);
    $('#export-to-pay-scale-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');

    $.ajax({
        url: `${BaseURL}/student/export/${format}`,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var downloadLink = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            downloadLink.href = url;
            downloadLink.download = `Students.${format}`;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            downloadLink.remove();
            window.URL.revokeObjectURL(url);
        }
    });

    $('#export-to-pay-scale-report-to-excel').attr("disabled", false);
    $('#export-to-pay-scale-report-to-excel').html('Export to Excel');
}
$('#export-to-student-data-report-to-excel').on('click', function (event) {
    event.preventDefault();
    exportStudentDataReport('xls')
});

$('#export-to-student-data-report-to-csv').on('click', function (event) {
    event.preventDefault();
    exportStudentDataReport('csv')
});

$('#export-to-student-data-who-not-purchased-report-to-excel').on('click', function (event) {
    event.preventDefault();


    $('#export-to-pay-scale-report-to-excel').attr("disabled", true);
    $('#export-to-pay-scale-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/export/exportNotPurchasedStudents/?, _blank');
    $('#export-to-pay-scale-report-to-excel').attr("disabled", false);
    $('#export-to-pay-scale-report-to-excel').html('Export to Excel');

});

$('#export-to-student-data-here-about-report-to-excel').on('click', function (event) {
    event.preventDefault();


    $('#export-to-student-data-here-about-report-to-excel').attr("disabled", true);
    $('#export-to-student-data-here-about-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/export/exportHearAboutIfalStudents/?, _blank');
    $('#export-to-student-data-here-about-report-to-excel').attr("disabled", false);
    $('#export-to-student-data-here-about-report-to-excel').html('Export to Excel');

});

$('#export-to-student-data-membership-report-to-excel').on('click', function (event) {
    event.preventDefault();


    $('#export-to-student-data-membership-report-to-excel').attr("disabled", true);
    $('#export-to-student-data-membership-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/export/exportMembershipIfalStudents/?, _blank');
    $('#export-to-student-data-membership-report-to-excel').attr("disabled", false);
    $('#export-to-student-data-membership-report-to-excel').html('Export to Excel');

});

$('#export-to-student-data-old-membership-report-to-excel').on('click', function (event) {
    event.preventDefault();


    $('#export-to-student-data-old-membership-report-to-excel').attr("disabled", true);
    $('#export-to-student-data-old-membership-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/export/exportOldMembershipIfalStudents/?, _blank');
    $('#export-to-student-data-old-membership-report-to-excel').attr("disabled", false);
    $('#export-to-student-data-old-membership-report-to-excel').html('Export to Excel');

});

$('#other_settings_submit').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/management/add-settings-update',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#other-settings-submit').attr("disabled", true);
            $('#other-settings-submit').html('<i class="icon-spinner4 spinner mr-2"></i>&nbsp;&nbsp;Updating..!');
        },
        success: function (response) {
            $('#other-settings-submit').attr("disabled", false);
            $('#other-settings-submit').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 1000);
            } else {
                toastr.error("Error!");
            }
        },
        error: function (data) {
            $('#other-settings-submit').attr("disabled", false);
            $('#other-settings-submit').html('Update');
            toastr.error("Error!");
        }
    });
});

$('#teacher-can-booking-trial-session-status-new').on('change', function (event) {
    event.preventDefault();

    var getProfileId = $('#reported-user-id').val();

    var bookingTrailSessionStatus;
    if ($('#teacher-can-booking-trial-session-status-new').prop("checked") == true) {
        bookingTrailSessionStatus = '1';
    } else if ($('#teacher-can-booking-trial-session-status-new').prop("checked") == false) {
        bookingTrailSessionStatus = '0';
    }

    $.ajax({
        url: BaseURLForAdmin + '/coach/changeTrailBookingStatusNew',
        data: {
            "reportedUserID": getProfileId,
            "bookingTrailSessionStatus": bookingTrailSessionStatus,
            "_token": csrf_token
        },
        type: 'POST',
        cache: false,
        beforeSend: function () {
            swal({
                title: "Loading...",
                text: "Please wait",
                button: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                swal({
                    title: "Success!",
                    icon: "success",
                    button: "Ok",
                }).then((value) => {
                    location.reload(true);
                });
                ;
            } else {
                toastr.error("Error!");
            }
        }
    });
});

$('#teacher_dyanmic_payscal_rate_count_submit').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/payScale/submitTeacherPayscaleRate',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#teacher-info-dynamic-pay-scale-rate-processing').attr("disabled", true);
            $('#teacher-info-dynamic-pay-scale-rate-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            $('#teacher-info-dynamic-pay-scale-rate-processing').attr("disabled", false);
            $('#teacher-info-dynamic-pay-scale-rate-processing').html('Submit');
            if (jsonData.status == 1) {
                swal({
                    title: "Success!",
                    icon: "success",
                    button: "Ok",
                }).then((value) => {
                    location.reload(true);
                });
                ;
            } else {
                toastr.error("Error!");
            }

        },
        error: function (data) {
            $('#teacher-info-dynamic-pay-scale-rate-processing').attr("disabled", false);
            $('#teacher-info-dynamic-pay-scale-rate-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

function getTeacherCurrentPayscaleRate(teacherId) {

    $.ajax({
        url: BaseURLForAdmin + '/payScale/getTeacherCurrentRate',
        type: 'POST',
        data: {
            '_token': csrf_token,
            'teacherId': teacherId
        },
        success: function (response) {
            jsonData = JSON.parse(response);
            $('#teacher_morning_payscal_rate_usd').val(jsonData.data.morningSessionUSD);
            $('#teacher_morning_payscal_rate_phi').val(jsonData.data.morningSessionPHI);

            $('#teacher_evening_payscal_rate_usd').val(jsonData.data.eveningSessionUSD);
            $('#teacher_evening_payscal_rate_phi').val(jsonData.data.eveningSessionPHI);

            $('#teacher_night_payscal_rate_usd').val(jsonData.data.nightSessionUSD);
            $('#teacher_night_payscal_rate_phi').val(jsonData.data.nightSessionPHI);
            console.log(jsonData);
        },
        error: function (data) {
            swal("Something went wrong!");
        }
    });

}

var teacherWisePayScaleListDatatabele = $('#teacher-wise-pay-scale-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

$('#analytics_for_close_deal_submit_for_average_membership').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/analytics/findAverageMembershipCount',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').attr("disabled", true);
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Searching..!');
        },
        success: function (response) {
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').attr("disabled", false);
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').html('Search');
            jsonData = JSON.parse(response);

            // MORNING
            $('#get-date-wise-analitics-percentage-for-close-deal-for-average-membership').text(jsonData.data.totalCloseDeal);

        },
        error: function (data) {
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').attr("disabled", false);
            $('#teacher-info-analytics-for-close-deal-for-average-membership-processing').html('Search');
            toastr.error("Error!");
        }
    });
});

function removeMembership(customerId) {

    swal({
        title: "Are you sure?",
        text: "Once remove, you will not be able to recover this membership!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/customers/removeMembership',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'customerId': customerId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1500);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

$('#filter_processing_for_cancel_membership_reason').on('submit', function (event) {
    event.preventDefault();
    var getSelectedValueURL = $('#select_filter_processing_for_cancel_membership_reason').val();
    // console.log(getSelectedValueURL);
    window.location.href = getSelectedValueURL;
});


// START TEACHER REVIEW

$('#submit_teacher_review').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: `${BaseURL}/management/review`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-teacher-review-processing').attr("disabled", true);
            $('#save-teacher-review-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-teacher-review-processing').attr("disabled", false);
            $('#save-teacher-review-processing').html('Submit');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-teacher-review-processing').attr("disabled", false);
            $('#save-teacher-review-processing').html('Submit');
            try {
                const parsedData = JSON.parse(data.responseText);
                toastr.error(parsedData.message ?? "Error!");
            } catch (e) {
                toastr.error("Error!");
            }
        }
    });
});

$('#edit_teacher_review').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    var reviewId = $('input[name="reviewId"]').val();
    formData.append('_token', csrf_token);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `${BaseURL}/management/review/${reviewId}`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-teacher-review-processing').attr("disabled", true);
            $('#edit-teacher-review-processing').html('<i`${BaseURL}/management/review` class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-teacher-review-processing').attr("disabled", false);
            $('#edit-teacher-review-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-teacher-review-processing').attr("disabled", false);
            $('#edit-teacher-review-processing').html('Update');
            try {
                const parsedData = JSON.parse(data.responseText);
                toastr.error(parsedData.message ?? "Error!");
            } catch (e) {
                toastr.error("Error!");
            }
        }
    });
});

var teacherReviewDatatabele = $('#lists-datatable-teacher_review').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteTeacherReview(reviewId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover review!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `${BaseURL}/management/review/${reviewId}`,
                    type: 'DELETE',
                    data: {
                        '_token': csrf_token,
                        'reviewId': reviewId
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        try {
                            const parsedData = JSON.parse(data.responseText);
                            swal(parsedData.message ?? "Error!");
                        } catch (e) {
                            swal("Something went wrong!");
                        }
                    }
                });
            }
        });


}

// END TEACHER REVIEW


// START TEACHER VIDEO

$('#submit_teacher_video').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: `${BaseURL}/management/video`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-teacher-video-processing').attr("disabled", true);
            $('#save-teacher-video-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-teacher-video-processing').attr("disabled", false);
            $('#save-teacher-video-processing').html('Submit');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-teacher-video-processing').attr("disabled", false);
            $('#save-teacher-video-processing').html('Submit');
            try {
                const parsedData = JSON.parse(data.responseText);
                toastr.error(parsedData.message ?? "Error!");
            } catch (e) {
                toastr.error("Error!");
            }
        }
    });
});

$('#edit_teacher_video').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var videoId = $('input[name="videoId"]').val();
    formData.append('_token', csrf_token);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `${BaseURL}/management/video/${videoId}`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-teacher-video-processing').attr("disabled", true);
            $('#edit-teacher-video-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-teacher-video-processing').attr("disabled", false);
            $('#edit-teacher-video-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-teacher-video-processing').attr("disabled", false);
            $('#edit-teacher-video-processing').html('Update');
            try {
                const parsedData = JSON.parse(data.responseText);
                toastr.error(parsedData.message ?? "Error!");
            } catch (e) {
                toastr.error("Error!");
            }
        }
    });
});

var teacherVideoDatatabele = $('#lists-datatable-teacher_video').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteTeacherVideo(videoId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover video!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `${BaseURL}/management/video/${videoId}`,
                    type: 'DELETE',
                    data: {
                        '_token': csrf_token,
                        'videoId': videoId
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        try {
                            const parsedData = JSON.parse(data.responseText);
                            swal(parsedData.message ?? "Error!");
                        } catch (e) {
                            swal("Something went wrong!");
                        }
                    }
                });
            }
        });


}

// END TEACHER VIDEO

var autoScheduleDatatabele = $('#customer-suto-schedule-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

$('#submit_membership_comment_for_student').on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/customers/addMembershipComment',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-membership-comment-for-student-processing').attr("disabled", true);
            $('#save-membership-comment-for-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-membership-comment-for-student-processing').attr("disabled", false);
            $('#save-membership-comment-for-student-processing').html('Save');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-membership-comment-for-student-processing').attr("disabled", false);
            $('#save-membership-comment-for-student-processing').html('Save');
            toastr.error("Error!");
        }
    });
});

var deletedCustomerList = $('#customer-who-deleted-lists-datatable').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/customers/getAllCustomersWhoDeleted',
        "type": "POST",
        data: {_token: csrf_token},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});


function openStudentNotiFicationTable() {
    // studentsNotificationDatatabele.ajax.reload();
    $('#selected_students_for_notification_from_table').val('');
    studentsNotificationDatatabele.ajax.reload();
}

var studentsNotificationDatatabele = $('#students-lists-datatable-for-notification').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/notification/getAllStudentsForNotification',
        "type": "POST",
        data: {_token: csrf_token},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});

function getStudentNotificationCheckBoxIds() {
    // console.log($("input[name='selectedNotificationStudents[]']:checked"));
    var getAllCheckBoxSelectedValuse = new Array();
    $.each($("input[name='selectedNotificationStudents[]']:checked"), function () {
        getAllCheckBoxSelectedValuse.push($(this).val());
    });

    var getFinalValuesOfStudentNotificationString = getAllCheckBoxSelectedValuse.toString();
    $('#selected_students_for_notification_from_table').val(getFinalValuesOfStudentNotificationString);
    // console.log(getFinalValuesOfStudentNotificationString);

}


function openStudentNotiFicationTableNew() {
    // studentsNotificationDatatabele.ajax.reload();
    // $('#selected_students_for_notification_from_table').val('');
    studentsNotificationDatatabeleNew.ajax.reload();
}


function getStudentNotificationCheckBoxIdsNew(studentId) {
    // console.log($("input[name='selectedNotificationStudents[]']:checked"));
    // var getAllCheckBoxSelectedValuse = new Array();
    // $.each($("input[name='selectedNotificationStudents']:checked"), function() {
    //     getAllCheckBoxSelectedValuse.push($(this).val());
    // });

    var isChecked = $('#' + studentId).is(":checked");
    if (isChecked) {
        studentId = $('#' + studentId).val();
        $.ajax({
            url: BaseURLForAdmin + '/notification/addSelectedUserIdForNotification',
            type: 'POST',
            data: {
                '_token': csrf_token,
                'studentId': studentId,
                'checkedStatus': 'CHECKED'
            },
            success: function (response) {
                jsonData = JSON.parse(response);
                if (jsonData.status == 1) {
                    $('#selected_students_for_notification_from_table_new').val(jsonData.data);
                    $('#get-selected-user-name-for-send-notification').text(jsonData.electedUserName);
                }
            },
        });
    } else {
        studentId = $('#' + studentId).val();
        $.ajax({
            url: BaseURLForAdmin + '/notification/addSelectedUserIdForNotification',
            type: 'POST',
            data: {
                '_token': csrf_token,
                'studentId': studentId,
                'checkedStatus': 'UNCHECKED'
            },
            success: function (response) {
                jsonData = JSON.parse(response);
                if (jsonData.status == 1) {
                    $('#selected_students_for_notification_from_table_new').val(jsonData.data);
                    $('#get-selected-user-name-for-send-notification').text(jsonData.electedUserName);
                }
            },
        });
    }


    // $('input[name="selectedNotificationStudentsNew"]').click(function(){
    //     if($(this).is(":not(:checked)")){
    //         // console.log("Check box in unchecked "+ $(this).val());
    //         $.ajax({
    //             url: BaseURLForAdmin + '/notification/addSelectedUserIdForNotification',
    //             type: 'POST',
    //             data: {
    //                 '_token': csrf_token,
    //                 'studentId': $(this).val(),
    //                 'checkedStatus':'UNCHECKED'
    //             },
    //             success: function (response) {},
    //         });
    //     }
    //     // else if($(this).is(":checked")){
    //     //     console.log("Check box in Checked "+ $(this).val());
    //     // }
    // });


    // $.each($("input[name='selectedNotificationStudents']:unchecked"), function() {
    //     alert($(this).val());
    // });

    // getAllCheckBoxSelectedValuse.push($(this).val());

    // var formData = new FormData($(this).closest('form')[0]);
    // formData.append('_token', csrf_token);
    //
    // $.ajax({
    //     url: BaseURLForAdmin + '/teacher_video/delete',
    //     type: 'POST',
    //     data: {
    //         '_token': csrf_token,
    //         'videoId': videoId
    //     },
    //     success: function (response) {
    //         jsonData = JSON.parse(response);
    //         if (jsonData.status == 1) {
    //             toastr.success("Success!");
    //             setInterval(function () {
    //                 location.reload(true);
    //             }, 1000);
    //         } else {
    //             swal("Something went wrong!");
    //         }
    //     },
    //     error: function (data) {
    //         swal("Something went wrong!");
    //     }
    // });

    // var getFinalValuesOfStudentNotificationString = getAllCheckBoxSelectedValuse.toString();
    // $('#selected_students_for_notification_from_table_new').val(getFinalValuesOfStudentNotificationString);
    // console.log(getFinalValuesOfStudentNotificationString);

}

var studentsNotificationDatatabeleNew = $('#students-lists-datatable-for-notification_new').DataTable({
    "processing": true,
    "responsive": false,
    "serverSide": true,
    "searching": true,
    "ordering": false,
    "ajax": {
        "url": BaseURLForAdmin + '/notification/getAllStudentsForNotificationNew',
        "type": "POST",
        data: {_token: csrf_token},
        dataFilter: function (data) {
            var json = jQuery.parseJSON(data);
            return JSON.stringify(json);
        }
    }
});


// START COMPANY MODULE

$('#submit_company_form').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);

    formData.append('_token', csrf_token);

    $.ajax({
        url: `${BaseURL}/companies`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-company-form-processing').attr("disabled", true);
            $('#save-company-form-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-company-form-processing').attr("disabled", false);
            $('#save-company-form-processing').html('Submit');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-company-form-processing').attr("disabled", false);
            $('#save-company-form-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_company_form').on('submit', function (event) {
    event.preventDefault();
    var formData = new FormData($(this).closest('form')[0]);
    var companyId = $('input[name="companyId"]').val();
    formData.append('_token', csrf_token);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `${BaseURL}/companies/${companyId}`,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-company-form-processing').attr("disabled", true);
            $('#edit-company-form-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-company-form-processing').attr("disabled", false);
            $('#edit-company-form-processing').html('Update');
            jsonData = response;
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-company-form-processing').attr("disabled", false);
            $('#edit-company-form-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var teacherVideoDatatabele = $('#lists-datatable-company_form').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteCompany(companyId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover Company!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `${BaseURL}/companies/${companyId}`,
                    type: 'DELETE',
                    data: {
                        '_token': csrf_token,
                    },
                    success: function (response) {
                        jsonData = response;
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

$('#company_session_count_submit').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/companies/getCompanyReport',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#company-session-count-processing').attr("disabled", true);
            $('#company-session-count-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Searching..!');
        },
        success: function (response) {
            $('#company-session-count-processing').attr("disabled", false);
            $('#company-session-count-processing').html('Search');
            jsonData = JSON.parse(response);
            // $('#teacher-total-completed-sessions').text(jsonData.data.completedCount);

            $('#company-total-completed-sessions').text(jsonData.data.totalCompletedSessions);
            $('#company-total-missed-sessions').text(jsonData.data.totalMissedSessions);
            $('#company-total-cancelled-sessions').text(jsonData.data.totalCancelledSessions);
            $('#company-total-student-who-attempted').text(jsonData.data.totalUsersCount);


            // $("#company-students-lists-datatable").DataTable().fnDestroy()

            if ($.fn.DataTable.isDataTable("#company-students-lists-datatable")) {
                $('#company-students-lists-datatable').DataTable().clear().destroy();
            }

            var coumpanyStudentsDatatabele = $('#company-students-lists-datatable').DataTable({
                "processing": true,
                "responsive": false,
                "serverSide": true,
                "searching": true,
                "ordering": false,

                "ajax": {
                    "url": BaseURLForAdmin + '/companies/getAllCompanyStudents',
                    "type": "POST",
                    data: {
                        _token: csrf_token,
                        current_selected_company: $('#get-current-selected-company-id').val(),
                        select_from_date_for_pay_scale_for_company: $('#select_from_date_for_pay_scale').val(),
                        select_to_date_for_pay_scale_for_company: $('#select_to_date_for_pay_scale').val()
                    },
                    dataFilter: function (data) {
                        var json = jQuery.parseJSON(data);
                        //            $('#customerTotalRecords').text(json.recordsTotal);
                        return JSON.stringify(json);
                    }
                }
            });

            // coumpanyStudentsDatatabele.ajax.reload();


        },
        error: function (data) {
            $('#company-session-count-processing').attr("disabled", false);
            $('#company-session-count-processing').html('Search');
            toastr.error("Error!");
        }
    });
});

function getCurrentSelectedCompany(companyId) {
    $('#get-current-selected-company-id').val(companyId);

}


$('#export-to-student-company-data-report-to-excel').on('click', function (event) {
    event.preventDefault();


    // var formData = new FormData($(this).closest('form')[0]);
    // formData.append('_token', csrf_token);
    // formData.append('select_from_date', $('#select_from_date_for_pay_scale').val());
    // formData.append('select_to_date', $('#select_to_date_for_pay_scale').val());
    //
    var fromDate = $('#select_from_date_for_pay_scale').val();
    var toDate = $('#select_to_date_for_pay_scale').val();
    var company = $('#get-current-selected-company-id').val();

    $('#export-to-student-company-data-report-to-excel').attr("disabled", true);
    $('#export-to-student-company-data-report-to-excel').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please wait..!');
    window.open(BaseURLForAdmin + '/companies/exportStudentWorksForCompany/?from=' + fromDate + '&to=' + toDate + '&company=' + company + '&_blank');
    $('#export-to-student-company-data-report-to-excel').attr("disabled", false);
    $('#export-to-student-company-data-report-to-excel').html('Export to Excel');

});


function changeSwitchery(element, checked) {
    if ((element.is(':checked') && checked == false) || (!element.is(':checked') && checked == true)) {
        element.parent().find('.switchery').trigger('click');
    }
}

$('.assign-free-session-for-company').on('change', function (event) {
    event.preventDefault();


    var assignCompanySessionStatus;
    if ($('.assign-free-session-for-company').prop("checked") == true) {

        var element = $('.assign-free-session-for-company-for-recurring');
        changeSwitchery(element, false);

        assignCompanySessionStatus = '1';
    } else if ($('.assign-free-session-for-company').prop("checked") == false) {
        assignCompanySessionStatus = '0';
    }


    if (assignCompanySessionStatus !== '1') {
        $('#no-of-assign-free-session-for-company').val(0);
        $('#is-show-for-assign-free-seaaion-for-company').addClass('hidden');
    } else {
        $('#is-show-for-assign-free-seaaion-for-company').removeClass('hidden');
    }


});


$('.assign-free-session-for-company-for-recurring').on('change', function (event) {
    event.preventDefault();


    var assignCompanySessionStatusForRecurring;
    if ($('.assign-free-session-for-company-for-recurring').prop("checked") == true) {

        var element = $('.assign-free-session-for-company');
        changeSwitchery(element, false);

        assignCompanySessionStatusForRecurring = '1';
    } else if ($('.assign-free-session-for-company-for-recurring').prop("checked") == false) {
        assignCompanySessionStatusForRecurring = '0';
    }


    if (assignCompanySessionStatusForRecurring != '1') {
        $('#company_package_frequncy_for_company').addClass('hidden');
        $('#company_package_start_date_for_company').addClass('hidden');
    } else {
        $('#company_package_frequncy_for_company').removeClass('hidden');
        $('#company_package_start_date_for_company').removeClass('hidden');
    }


});


// var coumpanyStudentsDatatabele = $('#company-students-lists-datatable').DataTable({
//     "processing": true,
//     "responsive": false,
//     "serverSide": true,
//     "searching": true,
//     "ordering": false,
//     "ajax": {
//         "url": BaseURLForAdmin + '/companies/getAllCompanyStudents',
//         "type": "POST",
//         data: {
//             _token: csrf_token,
//             current_selected_company: $('#get-current-selected-company-id').val(),
//             select_from_date_for_pay_scale_for_company: $('#select_from_date_for_pay_scale').val(),
//             select_to_date_for_pay_scale_for_company: $('#select_to_date_for_pay_scale').val()
//         },
//         dataFilter: function (data) {
//             var json = jQuery.parseJSON(data);
// //            $('#customerTotalRecords').text(json.recordsTotal);
//             return JSON.stringify(json);
//         }
//     }
// });

// END COMPANY MODULE

// START ADMIN USER MODULE

$('#submit_admin_user_form').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    // var ArticalContent = tinymce.get("add_artical_details").getContent();
    // formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/admin_user/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-admin-user-form-processing').attr("disabled", true);
            $('#save-admin-user-form-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-admin-user-form-processing').attr("disabled", false);
            $('#save-admin-user-form-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-admin-user-form-processing').attr("disabled", false);
            $('#save-admin-user-form-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_admin_user_form').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    // var ArticalContent = tinymce.get("edit_artical_details").getContent();
    // formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/admin_user/editAdminUser',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-admin-user-form-processing').attr("disabled", true);
            $('#edit-admin-user-form-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-admin-user-form-processing').attr("disabled", false);
            $('#edit-admin-user-form-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-admin-user-form-processing').attr("disabled", false);
            $('#edit-admin-user-form-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var adminUserDatatabele = $('#lists-datatable-admin_user_form').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteAdminUser(adminId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover Admin!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/admin_user/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'adminId': adminId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END ADMIN USER MODULE

// START BUSINESS ARTICAL

$('#submit_business_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("add_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/business_artical/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-business-artical-to-student-processing').attr("disabled", true);
            $('#save-business-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-business-artical-to-student-processing').attr("disabled", false);
            $('#save-business-artical-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-business-artical-to-student-processing').attr("disabled", false);
            $('#save-business-artical-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_business_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("edit_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/business_artical/editArtical',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-business-artical-to-student-processing').attr("disabled", true);
            $('#edit-save-business-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-business-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-business-artical-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-business-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-business-artical-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var businessArticalDatatabele = $('#business-artical-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteBusinessArtical(articalId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover business article!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/business_artical/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'articalId': articalId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END BUSINESS ARTICAL

// START KIDS LESSON

$('#submit_kids_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    // var ArticalContent = tinymce.get("add_artical_details").getContent();
    // formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/kids_lesson/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-kids-artical-to-student-processing').attr("disabled", true);
            $('#save-kids-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-kids-artical-to-student-processing').attr("disabled", false);
            $('#save-kids-artical-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-kids-artical-to-student-processing').attr("disabled", false);
            $('#save-kids-artical-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_kids_artical_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    // var ArticalContent = tinymce.get("edit_artical_details").getContent();
    // formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/kids_lesson/editLesson',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-kids-artical-to-student-processing').attr("disabled", true);
            $('#edit-save-kids-artical-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-kids-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-kids-artical-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-kids-artical-to-student-processing').attr("disabled", false);
            $('#edit-save-kids-artical-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var kidsLessonDatatabele = $('#kids-artical-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteKidsLesson(lessonId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover kids lesson!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/kids_lesson/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'lessonId': lessonId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END KIDS LESSON

// PAUSED MEMBERSHIP SECTION START

function cancelPausedMembership(customerId) {

    swal({
        title: "Are you sure?",
        text: "Once canceled, you will not be able to recover this membership!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/paused_membership/cancelMembershipForPaused',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'customerId': customerId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1500);
                        } else {
                            swal(jsonData.message);
                        }
                    },
                    error: function (data) {
                        // jsonData = JSON.parse(data);
                        swal(data.responseJSON.message);
                    }
                });
            }
        });


}

var studentReferralsDatatabele = $('#student-referrals-lists-datatable').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});


// PAUSED MEMBERSHIP SECTION END

// START GRAMMAR VIDEOS LESSON

$('#submit_grammar_videos_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/grammar_videos/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-grammar-video-to-student-processing').attr("disabled", true);
            $('#save-grammar-video-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-grammar-video-to-student-processing').attr("disabled", false);
            $('#save-grammar-video-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-grammar-video-to-student-processing').attr("disabled", false);
            $('#save-grammar-video-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_grammar_video_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/grammar_videos/editLesson',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-grammar-video-to-student-processing').attr("disabled", true);
            $('#edit-save-grammar-video-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-grammar-video-to-student-processing').attr("disabled", false);
            $('#edit-save-grammar-video-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-grammar-video-to-student-processing').attr("disabled", false);
            $('#edit-save-grammar-video-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var grammarVideoLessonDatatabele = $('#grammar-video-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": false,
});

function deleteGrammarVideoLesson(lessonId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover grammar video!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/grammar_videos/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'lessonId': lessonId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END GRAMMAR VIDEOS LESSON


// START  READING WORKSHEET FOR KIDS

$('#submit_reading_work_sheet_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("add_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/reading_worksheet/addNew',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#save-reading-worksheet-to-student-processing').attr("disabled", true);
            $('#save-reading-worksheet-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Submitting..!');
        },
        success: function (response) {
            $('#save-reading-worksheet-to-student-processing').attr("disabled", false);
            $('#save-reading-worksheet-to-student-processing').html('Submit');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#save-reading-worksheet-to-student-processing').attr("disabled", false);
            $('#save-reading-worksheet-to-student-processing').html('Submit');
            toastr.error("Error!");
        }
    });
});

$('#edit_submit_reading_worksheet_to_student').on('submit', function (event) {
    event.preventDefault();


    var formData = new FormData($(this).closest('form')[0]);
    var ArticalContent = tinymce.get("edit_artical_details").getContent();
    formData.append('artical_details', ArticalContent);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForAdmin + '/reading_worksheet/editReadingWorkSheet',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#edit-save-reading-worksheet-to-student-processing').attr("disabled", true);
            $('#edit-save-reading-worksheet-to-student-processing').html('<i class="icon-refresh spinner"></i>&nbsp;&nbsp;Please Wait..!');
        },
        success: function (response) {
            $('#edit-save-reading-worksheet-to-student-processing').attr("disabled", false);
            $('#edit-save-reading-worksheet-to-student-processing').html('Update');
            jsonData = JSON.parse(response);
            if (jsonData.status == 1) {
                toastr.success("Success!");
                setInterval(function () {
                    location.reload(true);
                }, 2000);
            } else {
                toastr.error(jsonData.message);
            }

        },
        error: function (data) {
            $('#edit-save-reading-worksheet-to-student-processing').attr("disabled", false);
            $('#edit-save-reading-worksheet-to-student-processing').html('Update');
            toastr.error("Error!");
        }
    });
});

var readingWorksheetDatatabele = $('#reading-worksheet-lists-datatable-for-student-in-admin').DataTable({
    "responsive": false,
    "searching": true,
    "ordering": true,
});

function deleteReadingWorksheet(articalId) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover Worksheet!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: BaseURLForAdmin + '/reading_worksheet/delete',
                    type: 'POST',
                    data: {
                        '_token': csrf_token,
                        'articalId': articalId
                    },
                    success: function (response) {
                        jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            toastr.success("Success!");
                            setInterval(function () {
                                location.reload(true);
                            }, 1000);
                        } else {
                            swal("Something went wrong!");
                        }
                    },
                    error: function (data) {
                        swal("Something went wrong!");
                    }
                });
            }
        });


}

// END  READING WORKSHEET FOR KIDS







