<!DOCTYPE HTML>
<html lang="en">
<head>
    @include('layouts.web_includes.head')
    <script>
        var BaseURLForCleaner = '<?= url('api/') ?>';
        var BaseURLForCustomer = '<?= url('api/') ?>';
        var BaseURL = '<?= url('') ?>';
        var StudentPortalBaseURL = '<?= config('constants.url.student_portal_url') ?>';
        var csrf_token = '{{ csrf_token() }}';
    </script>
</head>
<body>
<div class="loader-wrap">
    <div class="pin"></div>
    <div class="pulse"></div>
</div>
<!--loader end-->
<!-- Main  -->
<div id="main">
    <!-- header-->
    <div class="ss_main_header_ss">
        <header class="main-header dark-header fs-header">
            @include('layouts.web_includes.header_two')
        </header>
    </div>
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
<!-- Main end -->
@include('layouts.web_includes.buttom')
</body>
</html>




