@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-danger rounded-left">
                            <i class="icon-user font-large-2 text-white"></i>
                        </div>
                        <div class="p-2 media-body">
                            <h5>Total Students</h5>
                            <h5 class="text-bold-400 mb-0"><?= $getCustomers ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-info rounded-left">
                            <i class="icon-user font-large-2 text-white"></i>
                        </div>
                        <div class="p-2 media-body">
                            <h5>Total Teachers</h5>
                            <h5 class="text-bold-400 mb-0"><?= $totalCoaches ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-success rounded-left">
                            <i class="icon-basket-loaded font-large-2 text-white"></i>
                        </div>
                        <div class="p-2 media-body">
                            <h5>Total Sessions</h5>
                            <h5 class="text-bold-400 mb-0"><?= $totalAppointment ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 hidden">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-info rounded-left">
                            <i class="im im-whatsapp font-large-2 text-white"></i>
                        </div>
                        <div class="p-2 media-body">
                            <h5>Total WhatsApp Subscribers</h5>
                            <h5 class="text-bold-400 mb-0"><?= $totalWhatsAppSubscribers ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
