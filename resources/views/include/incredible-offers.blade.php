@if (sizeof($incredible_offers) > 0)
    <div class="row incredible-offers">
        <div class="col-3">
            <div style="margin-top: 20px">
                <a href="{{ url('') }}">
                    <img src="{{ 'files/images/Marasem1.jpg' }}" class="index-pic">
                </a>
                <a href="{{ url('') }}">
                    <img src="{{ 'files/images/cars.jpg' }}" class="index-pic">
                </a>
            </div>
        </div>
        <div class="col-9">
            <div class="discount_box">
                <div class="row">
                    <div class="discount_box_content">
                        @foreach ($incredible_offers as $key=>$value)
                            <div @if($key==0) style="display: block" @endif id="discount_box_link_{{ $value->id }}" class="item an">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="discount_bottom_bar"></div>
                                        <a href="{{ url('product/dkp-'.$value->id.'/'.$value->product_url) }}">
                                            <img src="{{ url('files/thumbnails/'.$value->img_url) }}">
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ url('product/dkp-'.$value->id.'/'.$value->product_url) }}">
                                            <div class="price_box">
                                                <del>{{ number_format($value->price1) }} تومان</del>
                                                <div class="incredible_offers_price">
                                                    <label>{{ number_format($value->price2) }} تومان</label>
                                                    <span class="discount_badge">
                                                        @php
                                                            $a = ($value->price2/$value->price1)*100;
                                                            $a = 100 - $a;
                                                            $a = round($a);
                                                        @endphp
                                                        {{ $a . ' ٪ تخفیف ' }}
                                                    </span>
                                                </div>
                                                <div class="discount_title">
                                                    {{ $value->title }}
                                                </div>
                                                <ul class="important_item_ul">
                                                    @foreach ($value->itemValue as $key=>$item)
                                                        @if ($key < 2)
                                                            <li>
                                                                {{ $item->important_item->title }} : 
                                                                {{ $item->item_value }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                @if ($value->product_number > 0)
                                                    <counter second="{{ $value->offers_last_time-time() }}"></counter>
                                                @else

                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="discount_left_item">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($incredible_offers as $key=>$value)
                            <div id="item_number_{{ $i }}" @if($i==0) class="active" @endif data-id="{{ $value->id }}">
                                {{ $value->getCat->name }}
                                @php
                                    $i++;
                                @endphp
                            </div>
                        @endforeach

                        @if (sizeof($incredible_offers) >= 9)
                            <a href="{{ url('incredible-offers') }}">
                                مشاهده همه پیشنهادات ویژه
                            </a>
                        @endif
                    </div>
                </div>
                <div class="discount_box_footer">
                    <div class="swiper-container" dir="rtl">
                        <div class="swiper-wrapper">
                            @foreach ($incredible_offers as $key=>$value)
                                <div class="swiper-slide @if($key==0) active @endif slide-amazing" data-id="{{ $value->id }}">
                                    {{ $value->getCat->name }}
                                </div>
                            @endforeach
                            @if (sizeof($incredible_offers) > 4)
                                <div class="swiper-slide"></div>
                                <div class="swiper-slide"></div>
                            @endif
                        </div>

                        <div class="swiper-pagination"></div>


                        <div class="slick-next"></div>
                        <div class="slick-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif