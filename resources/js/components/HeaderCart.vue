<template>
    <div>
        <div class="header_cart_box">
            <div class="basket_arrow"></div>
            <div class="box_label">
                <span>({{ CartProduct.product_count }}) کالا</span>
                <a v-bind:href="$siteUrl+'/cart'">مشاهده سبد خرید</a>
            </div>
            <div id="header_cart_content">
                <div v-if="CartProduct.product!=undefined && CartProduct.product.length>0">
                    <table class="cart_table">
                        <tr v-for="product in CartProduct['product']">
                            <td><img v-bind:src="$siteUrl+'/files/thumbnails/'+product.product_img_url"></td>
                            <td>
                                <ul>
                                    <li class="title">
                                        <a href="">{{ product.product_title }}</a>
                                    </li>
                                    <li>
                                        <div class="product_cart_info">
                                            <div>
                                                <span style="padding-left: 4px"> {{ product.product_count }} عدد</span>
                                                <span style="padding-left: 4px"> {{ product.product_roz2 }} روز</span>
                                            </div>
                                            <a  v-bind:href="$siteUrl+'/cart'" >
                                                <span class="fa fa-trash-o"></span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="box_label" style="height: 50px">
                <div class="mablaq">
                    <span>مبلغ قابل پرداخت : {{ CartProduct.cart_price }} تومان</span>
                </div>
                <a v-bind:href="$siteUrl+'/cart'" class="btn order_page">مشاهده سبد خرید</a>
            </div>
        </div>
        <!-- <div class="message_div" style="display:block" v-if="show_message_box">
            <div class="message_box">
                <p id="msg">آیا از حذف این محصول از لیست پیشنهاد ویژه مطمئن هستید ؟</p>
                <a class="alert alert-success" v-on:click="remove_of_list()">بله</a>
                <a class="alert alert-danger" v-on:click="show_message_box=!show_message_box">خیر</a>
            </div>
        </div> -->
    </div>
</template>

<script>
    import myMixin from "../myMixin";

    export default {
        name: "HeaderCart",
        mixins:[myMixin],
        data(){
            return{
                show_dialog_box:false,
                selected_product:null,
                CartProduct:{product:[]}
            }
        },
        mounted() {
            this.CartProductData();
        },
        methods:{
            CartProductData:function () {
                const url=this.$siteUrl+"/site/CartProductData";
                this.axios.get(url).then(response=>{
                    this.CartProduct=response.data;
                })
            },
            remove_product:function(product){
                this.selected_product=product;
                this.show_dialog_box=true;
            }
        }
    }
</script>

<style scoped>

</style>
