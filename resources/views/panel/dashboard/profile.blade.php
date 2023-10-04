@extends('layouts.admin_layout')
@section('content')        
<div class="content-body"><!-- Sales stats -->
    <div class="row">
        <div class="col-12">
            <div class="card profile-with-cover">
                <a href="#" class="profile-image">
                    <?php if (!empty($currentUserData->cover_image)): ?>
                        <div class="card-img-top img-fluid bg-cover height-300" style="background: url('<?= url('public/images/admin/') . '/' . $currentUserData->cover_image ?>') 50%;"></div>
                    <?php else: ?>
                        <div class="card-img-top img-fluid bg-cover height-300" style="background: url('<?= url('public/admin/') ?>/app-assets/images/carousel/22.jpg') 50%;"></div>
                    <?php endif; ?>
                </a>
                <div class="media profil-cover-details w-100">
                    <div class="media-left pl-2 pt-2">
                        <a href="#" class="profile-image">
                            <?php if (!empty($currentUserData->profile)): ?>
                                <img src="<?= url('public/images/admin/') . '/' . $currentUserData->profile ?>" class="rounded-circle img-border height-100" alt="Card image">
                            <?php else: ?>
                                <img src="<?= url('public/admin/') ?>/app-assets/images/portrait/small/avatar-s-8.png" class="rounded-circle img-border height-100" alt="Card image">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="media-body pt-3 px-2">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title"><b><?= ($currentUserData->name) ? $currentUserData->name : ''; ?></b></h3>
                            </div>
                            <div class="col text-right">

                            </div>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-light navbar-profile align-self-end">

                </nav>
            </div>
        </div>
    </div>          
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="zoom: 1; height: auto;" data-height="">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form">Edit Your Profile Info</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        <!--                        <div class="card-text">
                                                    <p>This is the most basic and default form having form sections. To add form section use <code>.form-section</code> class with any heading tags. This form has the buttons on the bottom left corner which is the default position.</p>
                                                </div>-->
                        <form class="form" action="<?= url('admin/') ?>/updateAdminProfile" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-body">
                                @include('error_message.flash_message')
                                <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">First Name</label>
                                            <input type="text" id="projectinput1" value="<?= $currentUserData->first_name ?>" class="form-control" placeholder="First Name" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2">Last Name</label>
                                            <input type="text" id="projectinput2" class="form-control" value="<?= $currentUserData->last_name ?>" placeholder="Last Name" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput3">E-mail</label>
                                            <input type="text" id="projectinput3" class="form-control" readonly value="<?= $currentUserData->email ?>" placeholder="E-mail" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput4">Contact Number</label>
                                            <input type="text" id="projectinput4" class="form-control" value="<?= $currentUserData->mobile ?>" placeholder="Phone" name="phone">
                                        </div>
                                    </div>
                                </div>

                                <h4 class="form-section"><i class="fa fa-image"></i> Medias</h4>                             

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput5">Profile Image</label>
                                            <label id="projectinput7" class="file center-block">
                                                <input type="file" id="file" name="profile">
                                                <span class="file-custom"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput6">Cover Image</label>
                                            <label id="projectinput7" class="file center-block">
                                                <input type="file" id="file" name="cover_image">
                                                <span class="file-custom"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" id="projectinput4" class="form-control" value="<?= base64_encode($currentUserData->id) ?>" name="admin_id">
                                        </div>
                                    </div>                                   
                                </div>    
                            </div>

                            <div class="form-actions">                              
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>          
</div>
@stop