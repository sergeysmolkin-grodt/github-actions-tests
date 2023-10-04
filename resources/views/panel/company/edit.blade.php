@extends('panel.layouts.admin_layout')
@section('content')  
<div class="content-body">
    <section id="configuration">
        <form class="form" id="edit_company_form">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-6">
                    <div class="card" style="min-height: 250px;">
                        <div  style="margin-top: -17px;">
                            <div class="card-body">
                                    <div class="form-body">
                                        <h4 class="form-section"><b><i class="icon-docs"></i> Company</b> </h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Name</label>
                                                    <input type="text" value="<?= $company->name ?>" class="form-control" placeholder="Name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="projectinput3">Country</label><br>
                                                <select class="form-control select2" name="country" style="height: calc(2.25rem + 10px);" required>
                                                    <option value="">Select Country</option>
                                                    <?php foreach($countries as $country): ?>
                                                        <option value="<?= $country['name'] ?>" <?php if($country['name'] == $company->country): echo 'selected'; endif;  ?> ><?= $country['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <input type="hidden" name="companyId" class="form-control-file" value="<?= $company->id ?>" required>
                            </div>
                         </div>
                        <hr>
                        <div class="col-xl-1 col-md-1 col-12">
                            <h3 style="text-align:right;">
                                <button type="submit" class="btn btn-primary" id="edit-company-form-processing">
                                    Update
                                </button>
                            </h3>
                        </div>
                </div>
            </div>
        </form>
    </section>
</div>
@stop
