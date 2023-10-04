<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-shadow navbar-semi-light btn-theme">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item"><a style="margin-top: 6px;" class="navbar-brand" href="<?php //= url('admin/adminhome') ?>">
                        <h1 class="brand-text" style="padding-left:65px;"><?= env('PROJECT_NAME') ?></h1></a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu">         </i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online">
{{--                                TODO: Implement reciving of profile info --}}
{{--                                <?php if (!empty(getCurrentAdminUserData()->profile)): ?> <?=  ?>--}}
{{--                                    <img src="<?= url('public/images/admin/') . '/' . getCurrentAdminUserData()->profile ?>"  alt="avatar">--}}
{{--                                <?php else: ?>--}}
                                    <img src="<?= env('APP_URL').'/public/admin/app-assets/images/portrait/small/avatar-s-1.png' ?>" alt="avatar">
                                <!----><?php //endif; ?><!---->
                            </span>
                            <span class="user-name"><?php //= getCurrentAdminUserData()->name; ?>Admin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?php //= url('admin/profile') ?><!---->"><i class="ft-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php //= url('admin/adminLogOut') ?>"><i class="ft-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
