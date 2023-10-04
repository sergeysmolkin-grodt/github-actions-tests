@if ($message = Session::get('success'))
<div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;text-align: left;">
    <span class="alert-icon"><i class="fa fa-check-circle"></i></span>   
    <strong style="font-weight:bold;">Success!</strong> {{ $message }}.
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-icon-right alert-danger alert-dismissible mb-2" style="text-align:left;" role="alert">
    <span class="alert-icon"><i class="fa fa-times-circle"></i></span>   
    <strong>{{ $message }}.</strong>
</div>   
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-icon-right alert-warning alert-dismissible mb-2" style="text-align:left;" role="alert">
    <span class="alert-icon"><i class="fa fa-warning"></i></span>   
    <strong>{{ $message }}.</strong>
</div>   
@endif


@if ($message = Session::get('info'))
<div class="alert alert-icon-right alert-info alert-dismissible mb-2" style="text-align:left;" role="alert">
    <span class="alert-icon"><i class="fa fa-info"></i></span>   
    <strong>{{ $message }}.</strong>
</div>  
@endif


<?php if ($errors->all()): ?>
    <?php foreach ($errors->all() as $error): ?>
        <div class="alert alert-icon-right alert-danger alert-dismissible mb-2" style="text-align:left;" role="alert">
            <span class="alert-icon"><i class="fa fa-times-circle"></i></span>           
            <strong>{{ $error }}.</strong>
        </div>
    <?php endforeach; ?>
<?php endif; ?>