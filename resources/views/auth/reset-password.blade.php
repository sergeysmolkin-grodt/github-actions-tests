@extends('layouts.web_layout_two')
@section('content') 
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-offset-3 col-lg-6 section_1">
                <div class="col-lg-12">
                    <div class="pass-input-wrap fl-wrap">
                        <img src="<?= url('public/admin/app-assets/images/logo/logo-dark.png') ?>" style="width:170px;margin:15px;">
                    </div>
                    @include('error_message.web_flash_message')
                    <div class="custom-form">
                        <form method="post" name="update-new-password-for-customer" id="update-new-password-for-customer">
                            {{ csrf_field() }}
                            <div class="pass-input-wrap fl-wrap">
                                <label>New Password</label>
                                <input type="password" name="password" class="pass-input" placeholder="" value="">
                                <span class="eye"><i class="fa fa-eye" style="color: #398294" aria-hidden="true"></i> </span>
                            </div>
                            <div class="pass-input-wrap fl-wrap">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="pass-input" placeholder="" value="">
                                <span class="eye"><i class="fa fa-eye" style="color:#398294;" aria-hidden="true"></i> </span>
                            </div>
                            <input type="hidden" name="token" class="pass-input" placeholder="" value="<?= $token ?>">
                            <input type="hidden" name="email" class="pass-input" placeholder="" value="<?= $email ?>">
                            <input type="hidden" name="isFromStudentPortal" id="isFromStudentPortal" class="pass-input" placeholder="" value="<?= $role->name === 'student' ? true : false ?>">
                            <div class="col-lg-12">
                                <button type="submit" class="log-submit-btn" id="update-new-password-processing-customer"><span>Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@stop
