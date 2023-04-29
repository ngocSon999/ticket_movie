@if(session('success'))
    <div class="alert alert-success text-center"> {{ session('success') }} </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning text-center"> {{ session('warning') }} </div>
@endif
@if(session('info'))
    <div class="alert alert-info text-center"> {{ session('info') }} </div>
@endif
@if(session('danger'))
    <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
