@extends('layouts.shop')

@section('content')
    {{-- @foreach ($cart_data as $item )

    {{ $item['id'] }}
        
    @endforeach --}}
    <renting-cart :cart_data="{{ json_encode( $cart_data ) }}"></renting-cart>
@endsection