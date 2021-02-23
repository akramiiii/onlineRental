<template>
    <div>
        <div class="renting_data_box" style="padding-right: 0px;padding-left:0px">
            <div class="swiper_product_box">
                <swiper :options="swiperOptions">
                    <swiper-slide v-for="product in OrderingData.cart_product_data" :key="product.product_id" class="product_info_box">
                        <img v-bind:src="$siteUrl+'/files/thumbnails/'+product.product_img_url">
                        <p>{{ product.product_title }}</p>

                    </swiper-slide>

                    <div class="swiper-button-next" slot="button-next"></div>
                    <div class="swiper-button-prev" slot="button-prev"></div>
                </swiper>
            </div>

            <div class="parent_checkout_image">
                <span class="checkout_image"></span>
                <div class="checkout_time">
                    <span>شیوه ارسال : عادی - </span>
                    <span>هزینه ارسال:</span>
                    <span>{{ OrderingData.normal_send_order_amount }}</span>
                </div>
            </div>
        </div>
        <ul class="checkout_action">
            <li>
                <a class="data-link" v-bind:href="$siteUrl+'/cart'">
                    بازگشت به سبد خرید
                </a>
            </li>
            <li>
                <a class="data-link continue_order_registration" id="continue_order_registration" style="cursor:pointer">
                    تایید و ادامه ثبت سفارش
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import myMixin from "../myMixin";
import { swiper, swiperSlide, directive} from 'vue-awesome-swiper';
import 'vue-awesome-swiper/node_modules/swiper/dist/css/swiper.css';
export default {
    name:"OrderingTime",
    props:['city_id'],
    mixins:[myMixin],
    components:{swiper,swiperSlide},
    directives: {
        swiper: directive
    },
        data(){
            return {
                OrderingData:[],
                swiperOptions: {
                    slidesPerView:5,
                    spaceBetween:30,
                    navigation:{
                        nextEl:'.swiper-button-next',
                        prevEl:'.swiper-button-prev',
                    }
                }
            }
        },
        mounted(){
          this.get_ordering_time();
        },
        methods:{
            get_ordering_time:function () {
                this.axios.get(this.$siteUrl+"/renting/getSendData/"+this.city_id).then(response=>{
                    this.OrderingData=response.data;
                    this.setPrice();
                });
            },
            setPrice:function () {
                $("#total_send_order_price").text(this.OrderingData.normal_send_order_amount);
                $("#final_price").text(this.OrderingData.normal_cart_price);
            }
        },
        watch:{
            city_id:function (newVal,oldVal) {
                this.city_id=newVal;
                this.get_ordering_time();
            }
        }
}
</script>