@extends('layouts.shop')

@section('content')
    <div class="row" id="product_box">
        <div class="col-3 item_box">    
            <li class="cat_product_re" style="list-style: none">
                <span class="mr-1">دسته بندی نتایج:</span>
            </li>
            <div class="divide"></div>
            <a href="{{ url('categories/'.$category->url) }}" class="title">
                <li class="cat_product_res">
                    <div class="mb-2">
                        <span class="fa fa-angle-left mr-1 title"></span>
                        <span >{{ $category->name }}</span>
                    </div>
                </li>
            </a>
            <a href="{{ url('subcategory/'.$category->url.'/'.$category2->url) }}" class="title">
                <li class="cat_product_res">
                    <div class="title mb-2">
                        <span class="mr-4 fa fa-angle-left title"></span>
                        <span>{{ $category2->name }}</span>
                    </div>
                </li>
            </a>
            @foreach ($category4 as $item)
                <li style="list-style: none" class="products">
                    <div class="mr-5 mb-1">
                        <a @if(request()->path() == 'subcategory/'.$category->url.'/'.$category2->url.'/'.$item->url) style="color: red" @endif href="{{ url('subcategory/'.$category->url.'/'.$category2->url.'/'.$item->url) }}"><span>{{ $item->name }}</span></a>
                        <br>
                    </div>  
                </li>  
            @endforeach
            {{--  @foreach ($category4 as $item)
                <li style="list-style: none" class="products">
                    <div class="mr-5 mb-1">
                        <a href="{{ url('subcategory/'.$category->url.'/'.$category2->url.'/'.$item->url) }}"><span>{{ $item->name }}</span></a>
                        <br>
                    </div> 
                </li>  
            @endforeach  --}}
        </div>

        <div class="col-9">
            <ul class="list-inline map_ul mb-5">
                <li><a href="{{ url('/') }}">خانه</a></li>/
                <li><a href="{{ url('categories/'.$category->url) }}">{{ $category->name }}</a></li>/
                <li><a href="{{ url('subcategory/'.$category->url.'/'.$category2->url) }}">{{ $category2->name }}</a></li>/
                @foreach ($category4 as $item)
                    @if(request()->path() == 'subcategory/'.$category->url.'/'.$category2->url.'/'.$item->url)
                        <li><a href="{{ url('subcategory/'.$category->url.'/'.$category2->url.'/'.$item->url) }}">{{ $item->name }}</a></li>
                    @endif
                @endforeach
            </ul>
            <div class="item_box">
                <div></div>
                <hr>
                <div class="products">

                </div>
            </div>
        </div>

        {{--  <div class="col-9" style="position:relative">
            <div style="display: flex;justify-content: space-between;align-items: center">
                <ul class="list-inline map_ul">
                    <li>
                        <a href="{{ url('/') }}">خانه</a>
                        @if(isset($category)) / @endif
                    </li>
                    @if(isset($category))
                        @if($category->getParent->getParent->name!="-")
                            <li><a href="{{ url('main/'.$category->getParent->getParent->url)  }}">{{ $category->getParent->getParent->name }}</a> </li>
                        @endif
                        @if($category->getParent->name!="-")
                            <li>  @if($category->getParent->getParent->name!="-")
                                      /
                                  @endif
                                <a href="{{ url('search/'.$category->getParent->url)  }}">{{ $category->getParent->name }}</a></li>
                        @endif
                        <li>
                            / <a href="{{ url()->current() }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endif
                </ul>
                <div id="product_count">
                </div>
            </div>
            <product-box></product-box>
        </div>    --}}
    </div>

@endsection

{{--  @section('head')
    <link rel="stylesheet" href="{{ url('css/nouislider.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/toggles-full.css') }}"/>
    <script type="text/javascript" src="{{ url('js/nouislider.min.js') }}"></script>
@endsection

@section('footer')
  <script type="text/javascript" src="{{ url('js/toggles.min.js') }}"></script>
  <script>
      $("#product_status").toggles({
          type:'Light',
          text:{'on':'','off':''},
          width:50,
          direction:'rtl',
          on:true
      });
      $("#send_status").toggles({
          type:'Light',
          text:{'on':'','off':''},
          width:50,
          direction:'rtl',
          on:true
      });
  </script>
@endsection  --}}
