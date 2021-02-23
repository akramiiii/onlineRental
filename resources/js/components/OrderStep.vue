<template>
    <div>
        <div class="swiper-container order_steps">
            <div class="swiper-wrapper">
                <div v-if="key>-1" class="swiper-slide" v-for="(step,key) in steps" :key="key">
                    <div :class="[ order_status<key ? 'step_div step_inactive' : 'step_div']" v-on:click="change_status(key)">

                        <img v-bind:src="$siteUrl+'/files/images/step'+key+'.svg'" :style="[key==5 ? {width:'85%'} : {}]" style="cursor:pointer"/>
                        <span>{{ step }}</span>
                    </div>

                    <hr v-if="key<5" :class="[order_status>key ? 'hr_active' : '' ]">

                    <div v-else style="min-width:66px"></div>

                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="message_div" style="display: block" v-if="show_box">
            <div class="message_box">
                <p id="msg">آیا از تغییر وضعیت مرسوله مطمئن هستین ؟ </p>
                <a class="alert alert-success" v-on:click="send_data()">بله</a>
                <a class="alert alert-danger" v-on:click="show_box=false">خیر</a>
            </div>

        </div>

        <div class="error_dialog">
            <span>خطا در ارسال اطلاعات - مجددا تلاش نمایید</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OrderStep",
        props:['steps','send_status','order_id'],
        data(){
           return{
               show_box:false,
               status:0,
               order_status:0
           }
        },
        mounted(){
          this.order_status=this.send_status;
        },
        methods:{
            change_status:function (status) {
                this.status=status;
                this.show_box=true; 
            },
            send_data:function () {
                this.show_box=false;
                $("#loading_box").show();
                const formData=new FormData();
                formData.append('order_id',this.order_id);
                formData.append('status',this.status);
                const url=this.$siteUrl+'/admin/order/change_status';
                this.axios.post(url,formData).then(response=>{
                    $("#loading_box").hide();
                    if(response.data=='ok'){
                        this.order_status=this.status;
                    }
                    else{
                        $('.error_dialog').show();
                        setTimeout(function () {
                            $('.error_dialog').hide();
                        },4000);
                    }
                }).catch(onerror=>{
                    $("#loading_box").hide();
                    $('.error_dialog').show();
                    setTimeout(function () {
                        $('.error_dialog').hide();
                    },4000);
                });
            }
        }
    }
</script>

<style scoped>

</style>
