<div class="index-cat-list container-fluid">
    <ul>
         <li class="cat_hover">
            <div></div>
        </li> 
        @foreach($catList as $key=>$value)
            <li class="cat_item">
                <a href="{{ url('categories/'.$value->url) }}">{{ $value->name }}</a>
                @if(sizeof($value->getChild)>0)
                    <div class="li_div">
                        <?php $c=0; ?>
                        @if(sizeof($value->getChild)>0) @if($c==0) <ul class="list-inline subList"> @endif @endif
                            @foreach($value->getChild as $key2=>$value2)
                                @if($value2->notShow==0)
                                    @if(get_show_category_count($value2->getChild)>=(14-$c)) <?php $c=0 ?>  </ul> <ul class="list-inline subList"> @endif
                            <li>
                                {{--  <a class="child_cat" href="{{ get_cat_url($value2) }}">  --}}
                                <a class="child_cat" href="{{ url('subcategory/'.$value->url.'/'.$value2->url) }}">
                                    <span class="fa fa-angle-left"></span>
                                    <span>{{ $value2->name }}</span>
                                </a>
                                <ul>
                                    @foreach($value2->getChild as $key3=>$value3)
                                        @if($value3->notShow==0)
                                            <li>
                                                {{--  <a href="{{ get_cat_url($value3) }}">{{ $value3->name }}</a>  --}}
                                                <a href="{{ url('subcategory/'.$value->url.'/'.$value2->url.'/'.$value3->url) }}">{{ $value3->name }}</a>
                                            </li>
                                            <?php $c++; ?>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <?php $c++ ?>
                            {{-- 13 --}}
                            @if($c==17)  </ul> <?php $c=0; ?> <ul class="list-inline subList"> @endif
                            @else
                                @foreach($value2->getChild as $key3=>$value3)
                                    @if(get_show_category_count($value3->getChild)>=(14-$c)) <?php $c=0 ?>  </ul> <ul class="list-inline subList"> @endif
                            @if($value3->notShow==0)
                                <li>
                                    <a class="child_cat" href="{{ get_cat_url($value3) }}">
                                        <span class="fa fa-angle-left"></span>
                                        <span>{{ $value3->name }}</span>
                                    </a>
                                    <ul>
                                        @foreach($value3->getChild as $key4=>$value4)
                                            @if($value4->notShow==0)
                                                <li>
                                                    <a href="{{ get_cat_url($value4) }}">{{ $value4->name }}</a>
                                                </li>
                                                <?php $c++; ?>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <?php $c++; ?>

                            @endif

                            @if($c==13)  </ul> <?php $c=0; ?> <ul class="list-inline subList"> @endif
                            @endforeach

                            @endif

                            @endforeach

                            @if($c!=0) </ul> @endif

                        <div class="show-total-sub-cat">
                            <a href="">
                                <span>مشاهده تمام دسته های </span>
                                <span>{{ $value->name }}</span>
                            </a>
                        </div>

                        @if(!empty($value->img))
                            <a href="">
                                <div class="sub-menu-pic">
                                    <img src="{{ url('files/uploads/'.$value->img) }}" />
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </li>
        @endforeach

        <li class="cat_item left_item">
            <a href="">فروش ویژه</a>
        </li>
    </ul>
</div>
