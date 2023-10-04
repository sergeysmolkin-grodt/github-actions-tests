@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body"><!-- Sales stats -->
    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--<h4 class="card-title">Customers List - (<b id="customerTotalRecords">0</b>)</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <table id="customer-lists-datatable-for-teacher" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Verification Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $teacher->firstname ?></td>
                                            <td><?= $teacher->lastname ?></td>
                                            <td><?= $teacher->email ?></td>
                                            <td><?= $teacher->userDetails->mobile ?></td>
                                            <td>
                                                @if ($teacher->is_active == 1)
                                                <span class="badge badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge badge-danger">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($teacher->teacherOptions->verification_status === 'verified')
                                                <span class="badge badge badge-success">Verified</span>
                                                @elseif ($teacher->teacherOptions->verification_status === 'rejected')
                                                <span class="badge badge badge-danger">Rejected</span>
                                                @else
                                                <span class="badge badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td><!-- TODO bind with time zone --><?= $teacher->created_at ?> </td>
                                            <td>
                                                <a href='<?= asset("/teacher-details/$teacher->id") ?>' class="dropdown-item text-primary"><i class="ft-eye"></i>&nbsp;&nbsp; View Details</a>
                                                <a href="<?= url("/teachers/$teacher->id/availabilities/") ?>" class="dropdown-item text-primary"><i class="ft-calendar"></i>&nbsp;&nbsp; Set availability</a>
                                                <a href="<?= asset("/teachers/$teacher->id") ?>" class="dropdown-item text-primary"><i class="ft-edit"></i>&nbsp;&nbsp; Edit</a>
                                                <a href="JavaScript:void(0);" onclick="deleteTeacher('<?=  $teacher->id; ?>')" class="dropdown-item text-primary"><i class="ft-trash"></i>&nbsp;&nbsp; Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
