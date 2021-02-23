@extends("layouts.shop")

@section('content')

    <div class="error_content">
        <h4>صفحه‌ای که دنبال آن بودید پیدا نشد!</h4>
        <a href="{{ url('/') }}" class="btn btn-success">صفحه اصلی</a>
    </div>

@endsection
