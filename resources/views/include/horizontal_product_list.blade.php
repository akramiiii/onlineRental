@if (sizeof($products) > 0)
    <div class="row">
        <div class="product_box">
            <div class="box_title">
                <h6>{{ $title }}</h6>
            </div>
            <div class="product_list" dir="rtl">
                @foreach ($products as $product)
                    <a href="{{ url('product/dkp-'.$product->id.'/'.$product->product_url) }}">
                        <div class="product">
                            <div class="product_img_div">
                                <img src="{{ url('files/thumbnails/'.$product->img_url) }}" >
                                @if ($product->offers == 1)
                                    <span class="discount_badge">
                                        <?php
                                            // $price1 = $product->price1 + $product->discount_price;
                                            $d = ($product->price2/$product->price1)*100;
                                            $d = 100 - $d;
                                            $d = round($d);
                                        ?>
                                        ٪{{ $d }}
                                    </span>
                                @endif
                            </div>
                            <p class="title">
                                @if (strlen($product->title) > 33)
                                    {{ mb_substr($product->title , 0 , 33).' ... ' }}
                                @else
                                    {{ $product->title }}
                                @endif
                            </p>
                            <p class="discount_price">
                                @if($product->offers==1)
                                    <del>{{ number_format($product->price1) }}</del>
                                    <p class="price">
                                        <span>روزانه | </span>
                                        {{ number_format($product->price2) . ' تومان'}}
                                    </p>
                                @elseif($product->offers == 0)
                                    <del></del>
                                    <p class="price">
                                        <span>روزانه | </span>
                                        {{ number_format($product->price1) . ' تومان'}}
                                    </p>
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif