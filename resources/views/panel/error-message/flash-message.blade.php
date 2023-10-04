@if ($message = Session::get('success'))
<div class="alert alert-icon-right alert-success alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="fa fa-check-circle"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>{{ $message }}.</strong>
</div>   
@endif


@if ($message = Session::get('error'))
<div class="alert alert-icon-right alert-danger alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="fa fa-times-circle"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>{{ $message }}.</strong>
</div>   
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-icon-right alert-warning alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="fa fa-warning"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>{{ $message }}.</strong>
</div>   
@endif


@if ($message = Session::get('info'))
<div class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="fa fa-info"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>{{ $message }}.</strong>
</div>  
@endif


<?php if ($errors->all()): ?>
    <?php foreach($errors->all() as $error): ?>
    <div class="alert alert-icon-right alert-danger alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-times-circle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>{{ $error }}.</strong>
    </div>
    <?php endforeach; ?>
<?php endif; ?>