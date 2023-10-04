<!DOCTYPE html>
<html >
    <head>
        <!-- THIS IS FOR HEAD-->
         @include('panel.layouts.admin_includes.head')
        <script>
            var BaseURLForAdmin = '{{ url('admin')  }}';
            var BaseURL = '{{ url('')  }}';
            var csrf_token = '{{ csrf_token() }}';
        </script>
    </head>
    <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

        <!-- THIS IS FOR TOP NEV BAR-->
         @include('panel.layouts.admin_includes.header')

        <!-- THIS IS FOR SIDE BAR-->
        <div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
            @include('panel.layouts.admin_includes.side_bar')
        </div>

        <!-- THIS IS FOR CONTENT-->
        <div class="app-content content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>


        <!-- THIS IS FOR FOOTER-->
         @include('panel.layouts.admin_includes.footer')


        @include('panel.layouts.admin_includes.buttom')
    </body>
</html>
