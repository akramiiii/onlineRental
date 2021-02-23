@extends('layouts.shop')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <ul class="list-inline map_ul">
                <li><a href="{{ url('/') }}">خانه</a></li>/
                <li>{{ $category->name }}</li>
            </ul>

            <div class="content card-columns" style="direction: rtl;text-align: right">
                @foreach($category->getChild as $key=>$value)
                    @if(sizeof($value->getChild)>0)
                        <div class="card child_cat_div">
                            @if(!empty($value->img))
                                <img src="{{ url('files/uploads/'.$value->img) }}" />
                            @endif
                            <p class="cat_name">{{ $value->name }}</p>
                            <ul>
                                @foreach($value->getChild as $key2=>$value2)
                                    <li>
                                        <a href="{{ url('subcategory/'.$value->getParent->url.'/'.$value->url.'/'.$value2->url) }}">
                                           {{ $value2->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
