/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#update-new-password-for-customer').on('submit', function (event) {
    event.preventDefault();

    var isFROMStudentPORTAL = $('#isFromStudentPortal').val();

    var formData = new FormData($(this).closest('form')[0]);
    formData.append('_token', csrf_token);

    $.ajax({
        url: BaseURLForCustomer + '/auth/reset-password',
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#update-new-password-processing-customer').html('<i class="fa fa-refresh fa-spin" style="font-size:16px"></i>&nbsp;&nbsp;<span>Processing..!</span>');
        },
        success: function (response) {
            $('#update-new-password-processing-customer').html('<span>Update Password</span>');
            jsonData = JSON.parse(response);
            if (jsonData.status) {
                toastr.success(jsonData.status);
                var timer = setTimeout(function () {
                    if(isFROMStudentPORTAL){
                        window.location = StudentPortalBaseURL;
                    }else{
                        window.location = BaseURL;
                    }

                }, 2500);
            } else {
                toastr.error(jsonData.error);
            }
        },
        error: function (data) {
            $('#update-new-password-processing-customer').html('<span>Update Password</span>');
            toastr.error("Somthing went wrong!");
        }
    });
});

