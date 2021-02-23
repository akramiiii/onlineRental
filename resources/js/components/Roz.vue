<template>
    <div class="app">    
        <div class="roz">
            <span id="roz">تعداد روز دلخواه (حداکثر 30 روز) : </span>
            <input v-model="number" id="roz_input" type="number" min="1" max="30" @change="send_roz()">
            <p class="final_product_price">
                <span class="rozane">قیمت نهایی : </span>
                <span style="font-size:24px !important; color: orangered">{{ calcute_final_price() | numFormat }} تومان</span>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name:"Roz" ,

    data(){
        return{
            number:[1],
            id:'',
            rozz:''
        }
    },
    
    props:['price1' , 'product_id'],

    mounted(){
        this.roz();
        this.calcute_final_price();
    },

    methods :{
        roz: function(){
           let roz = this.number=$('#roz_input').val();
        },

        calcute_final_price: function(){
            if(this.number < 1){
                setTimeout(() => {
                    this.number = 1;
                }, 150);
            }
            else if(this.number > 30){
                setTimeout(() => {
                    this.number = 30;
                }, 150);
            }
            for (let i = 1; i <= 30; i++) {
                var price = this.price1;
                var number = this.number;
                if(number == 1){
                    var s = (price * number);
                    return s;
                }
                else if(number > 1 && number < 6){
                    var s = Math.round(.85*(price * number));
                    return s;
                }
                else if(number > 5 && number < 16){
                    var s = Math.round(.8*(price * number));
                    return s;
                }
                else if(number > 15 && number < 26){
                    var s = Math.round(.75*(price * number) + parseInt(price));
                    return s;
                }
                else if(number > 25 && number < 31){
                    var s = Math.round(.75*(price * number) + parseInt(price));
                    return s;
                }
            }        
        },
        
        send_roz : function () {
            this.rozz=$('#roz_input').val();
            // this.id = product_id;
            // const formData = new FormData();
            // formData.append('rozz' , this.rozz);
            // formData.append('id' , this.id);

            const url = this.$siteUrl+"/cart";

            this.axios.post(url , this.rozz).then(response => {
                if(response.data == 'ok'){
                    alert('hi');
                }
            });

        }
    }
}
</script>