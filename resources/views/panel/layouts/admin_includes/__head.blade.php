<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="description" content="<?= PROJECT_NAME ?>">
<meta name="keywords" content="<?= PROJECT_NAME ?>">
<meta name="author" content="<?= PROJECT_NAME ?>">
<title><?= PROJECT_NAME ?></title>

<link rel="apple-touch-icon" href="<?= url('public/admin/app-assets/images/ico/apple-icon-120.png') ?>">

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<link rel="shortcut icon" type="image/x-icon" href="<?= url('public/admin/app-assets/images/ico/favicon.ico') ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>


<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/') ?>/app-assets/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/charts/morris.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/extensions/unslider.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/weather-icons/climacons.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/vendors/css/forms/toggle/switchery.min.css') ?>">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/app.min.css') ?>">
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/core/colors/palette-gradient.min.css') ?>">

<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/plugins/forms/switch.min.css') ?>">

<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/plugins/loaders/loaders.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/core/colors/palette-loader.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/plugins/calendars/clndr.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/app-assets/css/plugins/calendars/clndr.min.css') ?>">


<link rel="stylesheet" type="text/css" href="<?= url('public/admin/uploader/fancy_fileupload.css') ?>">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="<?= url('public/admin/assets/css/style.css') ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<link rel="stylesheet" type="text/css" href="<?= url('public/admin/codingzon/codingzon.css') ?>">



<style>
    html body .content .content-wrapper {
        padding: 0.3rem 1.2rem 0 18px;
    }

    .card-horizontal {
        display: flex;
        flex: 1 1 auto;
    }

    .img-container-block {
        text-align: center;
    }

    .img-container-inline {
        text-align: center;
        display: block;
    }

    .datepicker.dropdown-menu th, .datepicker.dropdown-menu td {
        padding: 15px 15px;
    }

    .datepicker.dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        min-width: 160px;
        list-style: none;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        border-right-width: 2px;
        border-bottom-width: 2px;
        color: #333333;
        line-height: 23px;
        font-size: 13px;
        line-height: 21px;
        font-family: Muli, Georgia, 'Times New Roman', Times, serif;
    }

    .datepicker td, .datepicker th {
        text-align: center;
        width: 68px;
        height: 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: none;
    }

    .fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
        border-color: #28aae1 !important;
    }

    .fc-day-grid-event {
        background-color: #28aae1 !important;
        border: 2px solid #28aae1 !important;
    }

    button:disabled {
        color: #28aae1 !important;
        background-color: transparent;
        border: 2px solid #28aae1 !important;
    }

    .fc-button {
        color: #28aae1 !important;
        background-color: transparent;
        border: 2px solid #28aae1 !important;
    }

    .btn-outline-primary:hover, .fc button:hover {
        color: #FFF !important;
        background-color: #28aae1 !important;
        border-color: #28aae1 !important;
    }

    #fc-default {
        max-width: 900px !important;
        margin: 0 auto !important;
    }
    
     .navbar-semi-light .navbar-nav .nav-link:hover{
        background-color:#28aae1 !important;
    }
     .navbar-semi-light .navbar-nav .nav-link:visited{
        background-color:#28aae1 !important;
    }
     .navbar-semi-light .navbar-nav .nav-link:focus{
        background-color:#28aae1 !important;
    }
</style>

