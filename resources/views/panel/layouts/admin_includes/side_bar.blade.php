<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'adminhome'): echo 'active'; endif; ?> nav-item"><a href="<?= env('APP_URL').'/admin-home' ?>"><i class="icon-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
        </li>
    </ul>

{{--    TODO: Add chech for super-Admin--}}
    <?php if('super-Admin' == 'sawandhamelia@gmail.com'): ?>
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/admin_user') ?>"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.dash.main">Admin Users</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'admin_user' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/admin_user/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'admin_user' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/admin_user/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
            </ul>
        </li>
    </ul>
    <?php endif; ?>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'customer_view'): echo 'active'; endif; ?> nav-item"><a href="<?= env('APP_URL').('/student') ?>"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.dash.main">Students</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'getAllCustomersUnsubscribed'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/getAllCustomersUnsubscribed') ?>"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.dash.main">Not purchased</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'everyMonthUsedSession'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/everyMonthUsedSession') ?>"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.dash.main">Used Sessions</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'oldMembership'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/oldMembership') ?>"><i class="icon-credit-card"></i><span class="menu-title" data-i18n="nav.dash.main">Old Membership</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'hear_about_ifal' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/hear_about_ifal/') ?>"><i class="icon-directions"></i><span class="menu-title" data-i18n="nav.dash.main">Hear About iFal</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher'): echo 'active'; endif; ?> nav-item"><a href="<?= env('APP_URL').'/teachers' ?>"><i class="icon-user"></i><span class="menu-title" data-i18n="nav.dash.main">Teachers</span></a>
        </li>
    </ul>

    <ul class="hidden navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'membership'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/membership') ?>"><i class="icon-credit-card"></i><span class="menu-title" data-i18n="nav.dash.main">Membership</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/customers/membership') ?>"><i class="icon-graph"></i></i><span class="menu-title" data-i18n="nav.dash.main">Membership</span></a>
            <ul class="menu-content" style="margin-left: -15px">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'membership'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/membership') ?>"><span class="menu-title" data-i18n="nav.dash.main">Active</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'oldMembership'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/oldMembership') ?>"><span class="menu-title" data-i18n="nav.dash.main">Past</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'paused_membership' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/paused_membership') ?>"><span class="menu-title" data-i18n="nav.dash.main">Paused</span></a></li>
            </ul>
        </li>
    </ul>


    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/appointments') ?>"><i class="icon-calendar"></i><span class="menu-title" data-i18n="nav.dash.main">Sessions</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'appointments' && \Illuminate\Support\Facades\Request::segment(3) == 'pastSessions'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/appointments/pastSessions') ?>"><span class="menu-title" data-i18n="nav.dash.main">Past </span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'appointments' && \Illuminate\Support\Facades\Request::segment(3) == 'upcommingSessions'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/appointments/upcommingSessions') ?>"><span class="menu-title" data-i18n="nav.dash.main">Upcoming </span></a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'notification' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/notification/send_notification_to_students_new') ?>"><i class="icon-bell"></i><span class="menu-title" data-i18n="nav.dash.main">Notification</span></a>
        </li>
    </ul>


    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'analytics'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/analytics/') ?>"><i class="icon-graph"></i><span class="menu-title" data-i18n="nav.dash.main">Analytics</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'payScale' && \Illuminate\Support\Facades\Request::segment(3) == 'pay_scal'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/payScale/pay_scal') ?>"><i class="icon-credit-card"></i><span class="menu-title" data-i18n="nav.dash.main">Pay Scale</span></a>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/artical') ?>"><i class="icon-docs"></i><span class="menu-title" data-i18n="nav.dash.main">Article</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'artical' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/artical/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'artical' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/artical/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/grammar') ?>"><i class="icon-docs"></i><span class="menu-title" data-i18n="nav.dash.main">Grammar</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'payScale' && \Illuminate\Support\Facades\Request::segment(3) == 'add_teacher_pay_scal'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/payScale/add_teacher_pay_scal') ?>"><i class="icon-credit-card"></i><span class="menu-title" data-i18n="nav.dash.main">Pay Scale Rate </span></a>
        </li>
    </ul>


    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/management') ?>"><i class="icon-settings"></i><span class="menu-title" data-i18n="nav.dash.main">Management</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'management' && \Illuminate\Support\Facades\Request::segment(3) == 'add-costs'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/management/add-costs') ?>" data-i18n="nav.dash.ecommerce">Package Price</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'management' && \Illuminate\Support\Facades\Request::segment(3) == 'privacy-policy'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/management/privacy-policy') ?>" data-i18n="nav.dash.ecommerce">Privacy Policy</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'management' && \Illuminate\Support\Facades\Request::segment(3) == 'terms-and-conditions'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/management/terms-and-conditions') ?>" data-i18n="nav.dash.ecommerce">Terms & Conditions</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'management' && \Illuminate\Support\Facades\Request::segment(3) == 'add-settings'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/management/add-settings') ?>" data-i18n="nav.dash.ecommerce">Support</a></li>

                <li class="has-sub is-shown"><a class="menu-item" href="#" data-i18n="nav.page_layouts.3_columns.main">Review</a>
                    <ul class="menu-content" style="">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_review' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('/management/review/create') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_review' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('/management/review/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>

                <li class="has-sub is-shown"><a class="menu-item" href="#" data-i18n="nav.page_layouts.3_columns.main">Video</a>
                    <ul class="menu-content" style="">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_video' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('/management/video/create') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_video' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('/management/video/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>

            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('company') ?>"><i class="icon-docs"></i><span class="menu-title" data-i18n="nav.dash.main">Company</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'companies' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('companies/create') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'companies' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('companies/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'companies' && \Illuminate\Support\Facades\Request::segment(3) == 'report'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('companies/report') ?>" data-i18n="nav.dash.ecommerce">View Report</a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('reports') ?>"><i class="icon-graph"></i></i><span class="menu-title" data-i18n="nav.dash.main">Reports</span></a>
            <ul class="menu-content" style="margin-left: -15px">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'getAllCustomersUnsubscribed'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/getAllCustomersUnsubscribed') ?>"><span class="menu-title" data-i18n="nav.dash.main">Not purchased</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'membershipCancelledReason'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/membershipCancelledReason') ?>"><span class="menu-title" data-i18n="nav.dash.main" title="Membership canceled reasons">Membership canceled <br> reasons</span></a></li>
                <li class=" <?php if(\Illuminate\Support\Facades\Request::segment(2) == 'appointments' && \Illuminate\Support\Facades\Request::segment(3) == 'cancelledWithReasonSessions'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/appointments/cancelledWithReasonSessions') ?>"><span class="menu-title" data-i18n="nav.dash.main" title="Session canceled reasons">Session canceled reasons</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'hear_about_ifal' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/hear_about_ifal/') ?>"><span class="menu-title" data-i18n="nav.dash.main">Hear About iFal</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'analytics' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/analytics/') ?>"><span class="menu-title" data-i18n="nav.dash.main">Analytics</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'analytics' && \Illuminate\Support\Facades\Request::segment(3) == 'average_membership'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/analytics/average_membership') ?>"><span class="menu-title" data-i18n="nav.dash.main">Avg Active Membership</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'studentWithNoTrialClass'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/studentWithNoTrialClass') ?>"><span class="menu-title" data-i18n="nav.dash.main">Without trial lesson</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'auto_schedule_users'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/auto_schedule_users') ?>"><span class="menu-title" data-i18n="nav.dash.main">Auto Scheduled Users</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'customers' && \Illuminate\Support\Facades\Request::segment(3) == 'getAllDeletedCustomers'): echo 'active'; endif; ?> nav-item"><a href="<?= url('admin/customers/getAllDeletedCustomers') ?>"><span class="menu-title" data-i18n="nav.dash.main">Deleted Users</span></a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'referrals' && \Illuminate\Support\Facades\Request::segment(3) == 'referrals'): echo 'active'; endif; ?> nav-item"><a href="<?= url('reports/referrals') ?>"><span class="menu-title" data-i18n="nav.dash.main">Referrals</span></a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('admin/teacher_video') ?>"><i class="icon-film"></i><span class="menu-title" data-i18n="nav.dash.main">Teachers Video</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_video' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/teacher_video/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'teacher_video' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/teacher_video/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main hidden" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="<?= url('management/review') ?>"><i class="icon-star"></i><span class="menu-title" data-i18n="nav.dash.main">Teachers Review</span></a>
            <ul class="menu-content">
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'review' && \Illuminate\Support\Facades\Request::segment(3) == 'create'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('management/review/create/') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'review' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/teacher_review/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
            </ul>
        </li>
    </ul>

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="#"><i class="icon-docs"></i><span class="menu-title" data-i18n="nav.templates.main">Materials</span></a>
            <ul class="menu-content">
                <li><a class="menu-item" href="<?= url('admin/artical') ?>" data-i18n="nav.templates.vert.main">Article</a>
                    <ul class="menu-content">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'artical' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/artical/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'artical' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/artical/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>
                <li><a class="menu-item" href="<?= url('admin/grammar') ?>" data-i18n="nav.templates.horz.main">Grammar</a>
                    <ul class="menu-content">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>
                <li><a class="menu-item" href="<?= url('admin/business_artical') ?>" data-i18n="nav.templates.horz.main">Business Article</a>
                    <ul class="menu-content">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'business_artical' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/business_artical/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'business_artical' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/business_artical/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>
                <li><a class="menu-item" href="<?= url('admin/kids_lesson') ?>" data-i18n="nav.templates.horz.main">Kids Lesson</a>
                    <ul class="menu-content">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'kids_lesson' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/kids_lesson/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'kids_lesson' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/kids_lesson/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>
                <li><a class="menu-item" href="<?= url('admin/grammar_videos') ?>" data-i18n="nav.templates.horz.main">Grammar Videos</a>
                    <ul class="menu-content">
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar_videos' && \Illuminate\Support\Facades\Request::segment(3) == 'add'): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar_videos/add') ?>" data-i18n="nav.dash.ecommerce">Add New</a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Request::segment(2) == 'grammar_videos' && \Illuminate\Support\Facades\Request::segment(3) == ''): echo 'active'; endif; ?>"><a class="menu-item" href="<?= url('admin/grammar_videos/') ?>" data-i18n="nav.dash.ecommerce">View All</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>



</div>
