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
                            <table id="lists-datatable-company_form" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#SR.No</th>
                                        <th>Company Name</th>
                                        <th>Country</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($companies as $companie): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= @$companie->name ?></td>
                                            <td><?= @$companie->country ?></td>
                                            <td>
                                                <a href="<?= url('companies/' . $companie->id. '/edit'); ?>" class="dropdown-item text-primary"><i class="ft-edit"></i>&nbsp;&nbsp; Edit</a>
                                                <a href="JavaScript:Void(0);" onclick="deleteCompany('<?=  $companie->id; ?>')" class="dropdown-item text-primary"><i class="ft-trash"></i>&nbsp;&nbsp; Delete</a>
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
