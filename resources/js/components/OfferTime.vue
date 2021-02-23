<template>
    <div class="offer_box" v-if="show_second>0">
        <span id="offers_time"></span>
        <img class="offer_pic" v-bind:src="this.$siteUrl+'/files/images/eccdcccd.png'">
        <div class="c-counter">
            <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name:"offerTime" ,
    data(){
        return {
            h:'',
            m:'',
            s:'',
            show_second:0
        }
    },
    props:['second'],
    mounted() {
        this.show_second = this.second;
        this.counter();
        setInterval(this.counter , 1000);
    },
    methods: {
        counter: function(){
            let second = this.show_second;
            let h = Math.floor(second/3600);
            second = second - h *3600;
            let m = Math.floor(second/60);
            let s = second - m * 60;
            if(h.toString().length == 1){
                h = "0" + h;
            }
            if(m.toString().length == 1){
                m = "0" + m;
            }
            if(s.toString().length == 1){
                s = "0" + s;
            }
            this.h = h;
            this.m = m;
            this.s = s;
            this.show_second = this.show_second-1;
        }
    },
}
</script>