<template>
    <div>
        <div v-if="CartProduct.product!=undefined && CartProduct.product.length>0">
            <div class="page_row">
                <div class="page_content">
                    <table class="cart_table">
                        <tr v-for="(product , index) in CartProduct['product']" :key="index">
                            <td>
                                <span class="fa fa-close remove_product" v-on:click="remove_product(product)"></span>
                            </td>
                            <td>
                                <img v-bind:src="$siteUrl+'/files/thumbnails/'+product.product_img_url">
                            </td>
                            <td>
                                <ul>
                                    <li class="title">
                                        <a href="">{{ product.product_title }}</a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <span>تعداد</span>
                                <p v-if="product.product_number_cart > 1">
                                    <select class="selectpicker" v-model="product.product_count" v-on:change="change_product_count(product)">
                                        <option v-for="(i , index) in product.product_number_cart" :key="index" v-bind:value="i">{{ i }}</option>
                                    </select>
                                </p>
                                <p v-else>{{ product.product_count }}</p>
                            </td>
                            <td>
                                <span>روز</span>
                                <!-- {{ product_roz2 }} -->
                                <p v-if="product.product_roz > 1">
                                    <select class="selectpicker" v-model="product.product_roz2" v-on:change="change_product_roz(product)">
                                        <option v-for="(i , index) in product.product_roz" :key="index" v-bind:value="i">{{ i }}</option>
                                    </select>
                                </p>
                                <p v-else>{{ product.product_roz }}</p>
                            </td>
                            <td v-if="product.product_offers == 0">
                                {{ product.price1 }} تومان
                            </td>
                            <td v-else-if="product.product_offers == 1">
                                {{ product.price2 }} تومان
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page_aside">
                    <div class="order_info">
                        <ul>
                            <li>
                                <span>مبلغ کل : </span>
                                <span>({{ CartProduct.product_count }}) کالا</span>
                                <span class="left">{{ CartProduct.total_price }} تومان</span>
                            </li>
                            <li class="cart_discount_li" v-if="CartProduct.discount != 0">
                                <span>سود شما از این سفارش : </span>
                                <span class="left">{{ CartProduct.discount }} تومان</span>
                            </li>
                            <li>
                                <span>هزینه ارسال : </span>
                                <span class="left">وابسته به آدرس</span>
                            </li> 
                        </ul>
                        <div class="checkout_devider"></div>
                        <div class="checkout_content">
                            <p style="color:red">مبلغ قابل پرداخت</p>
                            <p>{{ CartProduct.cart_price }} تومان</p>
                        </div>
                        <a v-bind:href="$siteUrl+'/renting'">
                            <div class="send_btn checkout">
                                <span class="line"></span>
                                <span class="title">ادامه ثبت سفارش</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="cart_table empty_cart_div">
            <span class="fa fa-shopping-basket"></span>
            <p>سبد سفارش شما خالی می باشد !</p>
        </div>
        <div class="message_div" v-if="show_dialog_box">
            <div class="message_box">
                <p id="msg">آیا مایل به حذف این محصول هستید ؟</p>
                <a class="alert alert-success" v-on:click="approve">بله</a>
                <a class="alert alert-danger" v-on:click="show_dialog_box=false,selected_product=null">خیر</a>
            </div>
        </div>
    </div>
</template>
<script>
import myMixin from '../myMixin'
export default {
    name: 'RentingCart',
    props:['cart_data'],
    data(){
        return{
            // product_roz2: 1,
            show_dialog_box : false,
            selected_product:null,
            CartProduct:{product:[]},
            // j:1,
        }
    },
    mixins:[myMixin],
    mounted(){
        this.CartProduct=this.cart_data;
    },
    methods:{
        remove_product : function(product){
            this.selected_product = product;
            this.show_dialog_box = true;
        },

        approve: function () {
            this.show_dialog_box=false;
            const url = this.$siteUrl+"/site/cart/remove_product";
            const formData = new FormData();
            formData.append('product_id' , this.selected_product.product_id);
            this.axios.post(url , formData).then(response => {
                if(response.data != 'error'){
                    this.CartProduct=response.data;
                }
            });
        },

        change_product_count: function(product){
            const url = this.$siteUrl+"/site/cart/change_product_count";
            const formData = new FormData();
            formData.append('product_id' , product.product_id);
            formData.append('product_count' , product.product_count);
            this.axios.post(url , formData).then(response => {
                if(response.data != 'error'){
                    this.CartProduct=response.data;
                }
            });
        },

        change_product_roz: function(product){
            const url = this.$siteUrl+"/site/cart/change_product_roz";
            const formData = new FormData();
            formData.append('product_id' , product.product_id);
            formData.append('product_roz2', product.product_roz2);
            // alert(this.product_roz2);
            this.axios.post(url , formData).then(response => {
                if(response.data != 'error'){
                    this.CartProduct=response.data;
                }
            });
        }
    }
}
</script>