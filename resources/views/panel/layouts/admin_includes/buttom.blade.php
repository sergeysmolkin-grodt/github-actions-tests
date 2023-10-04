<!-- BEGIN VENDOR JS-->
<script src="<?= url('public/admin/app-assets/vendors/js/vendors.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/tables/datatable/datatables.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/forms/toggle/switchery.min.js') ?>"></script>
<!-- BEGIN VENDOR JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<!--<script src="<?= url('public/admin/js/toastr.js') ?>"></script>-->

<script src="<?= url('public/js/sweetalert.min.js') ?>"></script>
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<!--<script src="<?= url('public/admin/js/sweetalert.min.js') ?>"></script>-->


<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= url('public/admin/app-assets/vendors/js/charts/raphael-min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/charts/chart.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/extensions/moment.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/vendors/js/extensions/fullcalendar.min.js') ?>"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="<?= url('public/admin/app-assets/js/core/app-menu.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/js/core/app.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/js/scripts/customizer.min.js') ?>"></script>
<script src="<?= url('public/admin/app-assets/js/scripts/forms/select/form-select2.min.js') ?>"></script>


<script src="<?= url('public/admin/app-assets/js/scripts/forms/switch.min.js') ?>"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
<!--<script src="<?= url('public/admin/js/all.js') ?>"></script>-->


<script src="<?= url('public/admin/app-assets/js/scripts/tables/datatables/datatable-basic.min.js') ?>"></script>

<script src="<?= url('public/admin/multiselect/jquery.multiselect.js') ?>"></script>


<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6C8xSgo241yhzCIzMZ4lwLdgnOfz5ME&sensor=true&libraries=places">
</script> -->

<?php if (\Illuminate\Support\Facades\Request::segment(3) != 'viewDetails'): ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--<script src="<?= url('public/admin/js/bootstrap.min.js') ?>"></script>-->
<!--<script src="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<!--<script src="<?= url('public/admin/js/bootstrap-datetimepicker.min.js') ?>"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--<script src="<?= url('public/admin/js/bootstrap.min.js') ?>"></script>-->


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--<script src="<?= url('public/admin/js/new_bootstrap.min.js') ?>"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<!--<script src="<?= url('public/admin/js/bootstrap-datepicker.js') ?>"></script>-->

<?php endif; ?>

<script src="<?= url('public/admin/codingzon/codingzon.js') ?>"></script>



<script type="text/javascript">

    $(document).ready(function () {
        $('#langOpt3').multiselect({
            columns: 0,
            placeholder: 'Select Students',
            search: true,
            selectAll: false
        });

        $('#langOpt4').multiselect({
            columns: 0,
            placeholder: 'Select Teachers',
            search: true,
            selectAll: false
        });

        var date = new Date();
        var todayDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $("#select_from_date_for_pay_scale").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        }).datepicker('setDate', todayDate);

        var date = new Date();
        var todayDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $("#select_to_date_for_pay_scale").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', todayDate);

        var date = new Date();
        var todayDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $("#select_to_date_for_company").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        }).datepicker('setDate', todayDate);

    });

    function copySessionStartURL(value){
        /* Get the text field */
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

      /* Alert the copied text */
      alert("Copied start Link.");
    }

    function copySessionJoinURL(value){
        /* Get the text field */
         var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

      /* Alert the copied text */
      alert("Copied join Link.");
    }

    $(function () {

        var date = new Date();
        //TODO investigate the functionality
        /*date.setDate(date.getDate());
        var dates = $.parseJSON($('#datetimepicker_holidays_list').text());
        var dateArray = $.parseJSON($('#datetimepicker_holidays_list').text())
        var makeDate = [];
        for (var i = 0; i < dates.length; i++) {
            var DateValues = new Date(dateArray[i]);
            makeDate.push(new Date(DateValues.getFullYear(), DateValues.getMonth(), DateValues.getDate()));
        }
        console.log(makeDate);

        $("#datetimepicker_holidays").datepicker({
            format: 'yyyy-mm-dd',
            multidate: true,
            startDate: '+0d',
            todayHighlight: true
        }).datepicker('setDate', makeDate);

        $("#custom_date_time_selector").datepicker({
            format: 'yyyy-mm-dd',
            multidate: false,
            startDate: '+0d',
            todayHighlight: true,
            autoclose: true
        }).datepicker('setDate', date);

        $('#months-tab').on('change', function () {
            // get month from the tab. Get the year from the current fullcalendar date
            var month = $(this).find(":selected").attr('data-month'),
                year = $("#fc-default").fullCalendar('getDate').format('YYYY');
            var m = moment([year, month, 1]).format('YYYY-MM-DD');
            $('#fc-default').fullCalendar('gotoDate', m);
        });*/

        const holidays = $.parseJSON($('#calendar_holidays_list').text());

        const holidayLists = holidays.map(obj => ({ start: obj.date, title: obj.type }));
        $("#fc-default").fullCalendar({
            defaultDate: date,
            editable: 0,
            eventLimit: !0,
            events: holidayLists,
        })


    });


    function toasterOptions() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        ;
    }

    $(document).ready(function () {
        const teacherId = $('#teacher-id').val();
        $.ajax({
            type: "POST",
            url: `${BaseURL}/get-month-wise-sessions`,
            data: {'_token': csrf_token, 'teacherId': teacherId},
            success: function (data) {
                jsonData = data
                new Chart(document.getElementById("bar_chart"), {
                    type: 'bar',
                    data: {
                        labels: jsonData.data.chartLabel,
                        datasets: [
                            {
                                label: "Total Sessions",
                                backgroundColor: "#DA4453",
                                data: jsonData.data.chartData
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: 'Month wise sessions'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 10,
                                    userCallback: function (label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }

                                    },
                                }
                            }],
                        }
                    }
                });
            }
        });

        var getChartUser = $('#document-user-id').val();
        $.ajax({
            type: "POST",
            url: BaseURLForAdmin + '/getYearUserData',
            data: {'_token': csrf_token, 'getChartUser': getChartUser},
            success: function (data) {
                jsonData = JSON.parse(data);
                new Chart(document.getElementById("bar_chart_for_year"), {
                    type: 'bar',
                    data: {
                        labels: jsonData.data.chartLabel,
                        datasets: [
                            {
                                label: "Total Sessions",
                                backgroundColor: "#DA4453",
                                data: jsonData.data.chartData
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: 'Year wise sessions'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                    userCallback: function (label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }

                                    },
                                }
                            }],
                        }
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        var maxField = 50; //Input fields increment limitation
        var addButton = $('.add_area_button'); //Add button selector
        var wrapper = $('.area_field_wrapper'); //Input field wrapper
        var default_remove_area_button = $('.default_area_field_wrapper'); //Input field wrapper
        //  var fieldHTML = '<div class="row"> <div class="col-xl-11 col-md-6 col-12"> <div class="row"> <div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" placeholder="Vocabulary Name" name="voc_name[]" required> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" placeholder="Vocabulary Pronunciation" name="voc_pro_name[]" required> </div></div><div class="col-md-2"> <div class="form-group"> <select id="projectinput5" name="voc_type[]" class="form-control" style="height: calc(2.25rem + 9px);"> <option value="design">design</option> <option value="development">development</option> </select> </div></div><div class="col-md-3"> <div class="form-group"> <textarea class="form-control" placeholder="Vocabulary Description" name="voc_desc[]" required></textarea> </div></div><div class="col-md-3"> <div class="form-group"> <textarea class="form-control" placeholder="Sample Sentence" name="voc_sample_sentance[]" required></textarea> </div></div></div></div><div class="col-xl-1 col-md-6 col-12"> <div class="form-group"> <a href="javascript:void(0);" class="remove_area_button"><img src="<?=url('public/remove-icon.png') ?>" style="margin-top:20px;"/></a></div></div></div>'; //New input field html

        var x = $('#totalVOC').val(); //Initial field counter is 1


        //Once add button is clicked
        $(addButton).click(function () {
            var fieldHTML = '<div class="row"> <div class="col-xl-11 col-md-6 col-12"> <div class="row"> <div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" placeholder="Word" name="vocabulary[voc_' + x + '][]" required> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" placeholder="Pronunciation" name="vocabulary[voc_' + x + '][]" required> </div></div><div class="col-md-2"> <div class="form-group"> <select id="projectinput5" name="vocabulary[voc_' + x + '][]" class="form-control" style="height: calc(2.25rem + 9px);" required> <option value="noun">noun</option> <option value="adjective">adjective</option> <option value="verb">verb</option> <option value="adverb">adverb</option> <option value="phrase">phrase</option> <option value="expression">expression</option> <option value="idiom">idiom</option> </select> </div></div><div class="col-md-3"> <div class="form-group"> <textarea class="form-control" placeholder="Meaning" name="vocabulary[voc_' + x + '][]" required></textarea> </div></div><div class="col-md-3"> <div class="form-group"> <textarea class="form-control" placeholder="Sample Sentence" name="vocabulary[voc_' + x + '][]" required></textarea> </div></div></div></div><div class="col-xl-1 col-md-6 col-12"> <div class="form-group"> <a href="javascript:void(0);" class="remove_area_button"><img src="<?=url('public/remove-icon.png') ?>" style="margin-top:20px;"/></a></div></div></div>'; //New input field html
            //Check maximum number of input fields
            // if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
            // }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_area_button', function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });

        //Once remove button is clicked
        $(default_remove_area_button).on('click', '.default_remove_area_button', function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });
    });

    $(document).ready(function () {
        var maxField = 50; //Input fields increment limitation
        var addButton = $('.add_area_button_qus'); //Add button selector
        var wrapper = $('.area_field_wrapper_qus'); //Input field wrapper
        var default_wrapper = $('.default_field_wrapper_new_qus'); //Input field wrapper
        var x = $('#totalMCQ').val();; //Initial field counter is 1


        //Once add button is clicked
        $(addButton).click(function () {
            // alert(x);
            var fieldHTML = '<div class="row" style="margin-top: 50px;"> <div class="col-md-11"> <div class="row"> <div class="col-md-12"> <div class="form-group"> <input type="text" class="form-control" placeholder="Question" name="question_name[qs_' + x + ']" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans[qs_' + x + ']" value="A" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans[qs_' + x + ']" value="B" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans[qs_' + x + ']" value="C" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans[qs_' + x + ']" value="D" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques[qs_' + x + '][]" autocomplete="off" required> </div></div></div></div><div class="col-md-1"><a href="javascript:void(0);" class="remove_button_new_qus"><img src="<?=url('public/remove-icon.png') ?>" style="margin-top:10px;"/></a></div></div>'; //New input field html
            //Check maximum number of input fields
            // if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
            // }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button_new_qus', function (e) {
            e.preventDefault();
            $(this).parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });

        //Once remove button is clicked
        $(default_wrapper).on('click', '.remove_button_new_qus', function (e) {
            e.preventDefault();
            $(this).parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });


    });

    $(document).ready(function () {
        var maxField = 50; //Input fields increment limitation
        var addButton = $('.add_area_button_for_discussion'); //Add button selector
        var wrapper = $('.area_field_wrapper_for_discussion'); //Input field wrapper
        var default_remove_area_button = $('.default_area_field_wrapper_for_discussion'); //Input field wrapper
        var fieldHTML = '<div class="row"> <div class="col-xl-11 col-md-6 col-12"> <div class="row"> <div class="col-md-12"> <div class="form-group"> <input type="text" class="form-control" placeholder="Discussion Sentence" name="further_discussion[]" required> </div></div></div></div><div class="col-xl-1 col-md-6 col-12"> <div class="form-group"> <a href="javascript:void(0);" class="remove_area_button_for_discussion"><img src="<?=url('public/remove-icon.png') ?>" style="margin-top:10px;"/></a></div></div></div>'; //New input field html
        var x = 1; //Initial field counter is 1


        //Once add button is clicked
        $(addButton).click(function () {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_area_button_for_discussion', function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

        //Once remove button is clicked
        $(default_remove_area_button).on('click', '.remove_area_button_for_discussion', function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

    $(document).ready(function () {
        var maxField = 50; //Input fields increment limitation
        var addButton = $('.add_area_button_qus_gram'); //Add button selector
        var wrapper = $('.area_field_wrapper_qus_gram'); //Input field wrapper
        var default_wrapper = $('.default_field_wrapper_new_qus_gram'); //Input field wrapper
        var x = $('#totalMCQGRAM').val(); //Initial field counter is 1


        //Once add button is clicked
        $(addButton).click(function () {
            // alert(x);
            var fieldHTML = '<div class="row" style="margin-top: 50px;"> <div class="col-md-11"> <div class="row"> <div class="col-md-12"> <div class="form-group"> <input type="text" class="form-control" placeholder="Question" name="question_name_gram[qs_' + x + ']" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans_gram[qs_' + x + ']" value="A" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques_gram[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans_gram[qs_' + x + ']" value="B" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques_gram[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans_gram[qs_' + x + ']" value="C" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques_gram[qs_' + x + '][]" autocomplete="off" required> </div></div><div class="col-md-3"> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><input type="radio" name="ans_gram[qs_' + x + ']" value="D" required></span> </div><input type="text" class="form-control" placeholder="Option"  name="art_ques_gram[qs_' + x + '][]" autocomplete="off" required> </div></div></div></div><div class="col-md-1"><a href="javascript:void(0);" class="remove_button_new_qus_gram"><img src="<?=url('public/remove-icon.png') ?>" style="margin-top:10px;"/></a></div></div>'; //New input field html
            //Check maximum number of input fields
            // if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
            // }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button_new_qus_gram', function (e) {
            e.preventDefault();
            $(this).parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });

        //Once remove button is clicked
        $(default_wrapper).on('click', '.remove_button_new_qus_gram', function (e) {
            e.preventDefault();
            $(this).parent().parent('div').remove(); //Remove field html
            // x--; //Decrement field counter
        });


    });


</script>


<!-- END PAGE LEVEL JS-->
