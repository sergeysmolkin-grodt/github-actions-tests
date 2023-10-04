<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

    <!-- Mirrored from pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/login-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Nov 2018 04:27:47 GMT -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="iFAL APP">
        <meta name="keywords" content="iFAL APP">
        <meta name="author" content="iFAL APP">
        <title><?= env('PROJECT_NAME') ?> Admin Login</title>
        <link rel="apple-touch-icon" href="<?= env('APP_URL').'/public/admin/' ?>/app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robust/app-assets/images/ico/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/vendors/css/forms/icheck/icheck.css">
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/vendors/css/forms/icheck/custom.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN ROBUST CSS-->
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin'?>/app-assets/css/app.min.css">
        <!-- END ROBUST CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/css/core/colors/palette-gradient.min.css">
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/app-assets/css/pages/login-register.min.css">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin' ?>/assets/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="<?= env('APP_URL').'/public/admin/codingzon/codingzon.css' ?>">

        <!-- END Custom CSS-->
    </head>
    <body class="login-background vertical-layout vertical-menu 1-column  menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="1-column">
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body"><section class="flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-md-3 col-10 box-shadow-2 p-0">
                                <div class="card border-grey border-lighten-3 m-0">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <img src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/images/logo/logo-dark.png" alt="branding logo" style="width:250px;">
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Login with <?= env('PROJECT_NAME') ?></span></h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            @include('panel.error-message.flash-message')
                                            <form class="form-horizontal" action="<?= env('APP_URL')?>/login" method="POST">
                                                {{ csrf_field() }}
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="email" class="form-control input-lg" name="email" id="user-name" placeholder="Your Email" tabindex="1" required>
                                                    <div class="form-control-position">
                                                        <i class="ft-user"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Enter Password" tabindex="2" required>
                                                    <div class="form-control-position">
                                                        <i class="ft-unlock"></i>
                                                    </div>
                                                    <div class="help-block font-small-3"></div>
                                                </fieldset>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-12 text-center text-md-left">
                                                        <!--                                                        <fieldset>
                                                                                                                    <input type="checkbox" id="remember-me" class="chk-remember">
                                                                                                                    <label for="remember-me"> Remember Me</label>
                                                                                                                </fieldset>-->
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="ft-unlock"></i> Login</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <!-- BEGIN VENDOR JS-->
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN ROBUST JS-->
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/js/core/app-menu.min.js"></script>
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/js/core/app.min.js"></script>
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/js/scripts/customizer.min.js"></script>
        <!-- END ROBUST JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script src="<?= env('APP_URL').'/public/admin/' ?>/app-assets/js/scripts/forms/form-login-register.min.js"></script>
        <!-- END PAGE LEVEL JS-->
    </body>

    <!-- Mirrored from pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/login-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Nov 2018 04:27:47 GMT -->
</html>
