@if (Session::has('message'))
    <div class="alert alert-success alert-dismissable fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="close ml-3" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif