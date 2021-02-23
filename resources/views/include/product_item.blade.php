<div class="item_content">
    @if (sizeof($product_items)>0 && $product_item_count > 0)
        <h3>مشخصات محصول</h3>
        <table class="item_table">
            @foreach ($product_items as $key=>$value)
                @foreach ($value->getChild as $key2=>$value2)
                    @if (sizeof($value2->getValue) > 0)
                        <tr>
                            <td colspan="2" style="padding: 15px 0">
                                <span class="item_name">{{ $value->title }}</span>
                            </td>
                        </tr>
                        <?php break; ?>
                    @endif
                @endforeach

                @foreach ($value->getChild as $key2=>$value2)
                    @if (sizeof($value2->getValue)>0)
                        <tr>
                            <td class="product_item_name">
                                <p>{{ $value2->title }}</p>
                            </td>
                            <td class="product_item_value">
                                <p>{{ $value2->getValue[0]->item_value }}</p>
                            </td>
                        </tr>
                        @foreach ($value2->getValue as $key3=>$value3)
                            @if ($key3>0)
                                <tr>
                                    <td class="product_item_name">
                                    </td>
                                    <td class="product_item_value">
                                        <p>{{ $value3->item_value }}</p>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </table>
    @else
        <p class="empty_message">
            مشخصاتی برای این محصول ثبت نشده است 
        </p>
    @endif

</div>