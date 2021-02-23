@extends('layouts.shop')

@section('content')
    <div class="row slider">
        <div class="col-2">
            <div>
                <a href="{{ url('') }}">
                    <img src="{{ 'files/images/Marasem1.jpg' }}" class="index-pic" @if(sizeof($incredible_offers)==0) style="height: 155px" @endif>
                </a>
                <a href="{{ url('') }}">
                    <img src="{{ 'files/images/cars.jpg' }}" class="index-pic" @if(sizeof($incredible_offers)==0) style="height: 155px" @endif>
                </a>
                @if (sizeof($incredible_offers) > 0)
                    <a href="{{ url('') }}">
                        <img src="{{ 'files/images/5cd7ee17a9cfdغرفه سازی.jpg' }}" class="index-pic">
                    </a>
                    <a href="{{ url('') }}">
                        <img src="{{ 'files/images/5c389dcb4bd34download.jpg' }}" class="index-pic">
                    </a>
                @endif
            </div>
        </div>
        <div class="col-10">
            @if (sizeof($slider) > 0)
                <div class="slider_box">
                    <div style="position: relative">
                        @foreach ($slider as $key=>$value)
                            <div class="slide_div an"  id="slider_img_{{ $key }}" @if($key==0) style="display: block" @endif>
                                <a href="{{ $value->url }}" style="background-image: url('{{ url('files/slider/'.$value->image_url) }}')"></a>
                            </div>
                        @endforeach
                    </div>

                    <div id="right_slide" onclick="previous()"></div>
                    <div id="left_slide" onclick="next()"></div>
                </div>
                <div class="slider_box_footer">
                    <div class="slider_bullet_div">
                        @for ($i = 0; $i < sizeof($slider); $i++)
                            <span id="slider_bullet_{{ $i }}" @if($i==0) class="active" @endif></span>
                        @endfor
                    </div>
                </div>
            @endif

            @include('include.incredible-offers' , ['incredible_offers' => $incredible_offers])

        </div>
    </div> 

    @include('include.horizontal_product_list' , ['title' => 'جدیدترین محصولات سایت' , 'products' => $new_product])

    @include('include.horizontal_product_list' , ['title' => 'پراجاره ترین محصولات سایت' , 'products' => $best_renting_product])
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">

    <link rel="stylesheet" href="{{ asset('slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('slick/slick.min.js') }}"></script>
    <script>
        load_slider('{{ sizeof($slider) }}');
        const swiper = new Swiper('.swiper-container' , {
            slidesPerView: 'auto',
            spaceBetween: 10,
            navigation:{
                nextEl:'.slick-next',
                prevEl:'.slick-prev',
            }
        });

        $('.product_list').slick({
            speed:900,
            slidesToShow:4,
            slidesToScroll:3,
            rtl:true,
            infinite:false
        });
    </script>
    
    <?php
        if(sizeof($incredible_offers) < 6){
            ?>
            <script>
                $('.discount_box_footer .slick-next').hide();
                $('.discount_box_footer .slick-prev').hide();
            </script>
            <?php
        }
    ?>
@endsection