<template>
    <div class="app">
        <div class="search_form">
            <input type="text" v-model="search_text" class="form-control" placeholder="نام محصول ...">
            <button class="btn btn-primary" v-on:click="getList(1)">جست و جو</button>
        </div>

        <table class="table table-bordered">
            <thead>
              <tr>
                  <th>ردیف</th>
                  <th>تصویر</th>
                  <th>عنوان محصول</th>
                  <th>عملیات</th>
              </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in List.data" :key="index">
                    <td>{{ getRow(index) }}</td>
                    <td>
                        <img v-bind:src="$siteUrl+'/files/thumbnails/'+item.img_url" class="product_pic">
                    </td>
                    <td style="font-size:14px">
                        {{ item.title }}
                    </td>
                    <td style="width:150px">
                        <p class="select_item" v-on:click="show_box(item.id , index)">انتخاب</p>
                        <p v-if="item.offers==1" v-on:click="remove_offers(item.id , index)" class="remove_item">حذف</p>
                    </td>      
                </tr>
            </tbody>
        </table>

        <pagination :data="List" @pagination-change-page="getList"></pagination>

        <div class="message_div" style="display:block" v-if="show_message_box">
            <div class="message_box">
                <p id="msg">آیا از حذف این محصول از لیست پیشنهاد ویژه مطمئن هستید ؟</p>
                <a class="alert alert-success" v-on:click="remove_of_list()">بله</a>
                <a class="alert alert-danger" v-on:click="show_message_box=!show_message_box">خیر</a>
            </div>
        </div>

        <div class="modal fade" id="priceBox" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5> افزودن به لیست پیشنهاد شگفت انگیز </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="server_errors" class="alert alert-warning" style="padding-bottom:0 !important;">
                            <ul class="list-inline">
                                <li v-for="(error, index) in server_errors" :key="index">
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>هزینه محصول : </label>
                            <cleave :options="options" v-model="formInput.price1" class="form-control left" />
                            <span class="has_error" v-if="errors.price1_error">{{ errors.price1_error }}</span>
                        </div>
                        <div class="form-group">
                            <label>هزینه محصول برای فروش : </label>
                            <cleave :options="options" v-model="formInput.price2" class="form-control left" />
                            <span class="has_error" v-if="errors.price2_error">{{ errors.price2_error }}</span>
                        </div>

                        <div class="form-group">
                            <label>تعداد موجودی محصول : </label>
                            <cleave :options="options" v-model="formInput.product_number" class="form-control left" />

                            <span class="has_error" v-if="errors.product_number_error">{{ errors.product_number_error }}</span>
                        </div>

                        <div class="form-group">
                            <label>تعداد قابل سفارش در سبد خرید : </label>
                            <cleave :options="options" v-model="formInput.product_number_cart" class="form-control left" />
                            <span class="has_error" v-if="errors.product_number_cart_error">{{ errors.product_number_cart_error }}</span>
                        </div>

                        <div class="form-group">
                            <label>تاریخ شروع : </label>
                            <input type="text" v-model="date1" id="pcal1" class="form-control" style="text-align:center" />
                        </div>

                        <div class="form-group">
                            <label>تاریخ پایان : </label>
                            <input type="text" v-model="date2" id="pcal2" class="form-control" style="text-align:center" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" v-on:click="add()">افزودن</button>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        name: "IncredibleOffers",
        data(){
            return {
                List:{data:[]},
                page:1,
                formInput:{
                    price1:'',
                    price2:'',
                    product_number:'',
                    product_number_cart:''
                },
                options:{
                    numeral:true
                },
                date1:'',
                date2:'',
                select_key:-1,
                product_id:-1,
                send_form:true,
                show_message_box:false,
                errors:{
                    price1_error:false,
                    price2_error:false,
                    product_number_error:false,
                    product_number_cart_error:false,
                },
                label:{
                    price1:'هزینه محصول',
                    price2:'هزینه محصول برای فروش',
                    product_number:'تعداد موجودی محصول',
                    product_number_cart:'تعداد قابل سفارش در سبد خرید',
                },
                search_text:'',
                server_errors:null,
            }
        },
        mounted(){
            this.getList(1);
        },
        methods:{
            getList : function(page){
                this.page=page;
                const url = this.$siteUrl+'/admin/ajax/getProduct?page='+page+"&search_text="+this.search_text;
                this.axios.get(url).then(response => {
                    this.List=response.data;
                    // console.log(response.data);
                });
            },
            getRow : function(index){
                ++index;
                let k = (this.page-1)*10;
                k = k + index;
                return k;
            },
            show_box : function(item_id , index){
                if(this.send_form == true){
                    this.server_errors=false;
                    this.product_id = item_id;
                    this.select_index = index;
                    this.formInput.price1=this.List.data[index].price1;
                    this.formInput.price2=this.List.data[index].price2;
                    this.formInput.product_number=this.List.data[index].product_number;
                    this.formInput.product_number_cart=this.List.data[index].product_number_cart;
                    this.date1 = this.List.data[this.select_index].offers_first_date;
                    this.date2 = this.List.data[this.select_index].offers_last_date;
                    $('#priceBox').modal('show');
                }
            },
            add : function(){
                this.date1=$('#pcal1').val();
                this.date2=$('#pcal2').val();
                if(this.validateForm()){
                    this.send_form=false;
                    const formData = new FormData();
                    formData.append('price1' , this.formInput.price1);
                    formData.append('price2' , this.formInput.price2);
                    formData.append('product_number' , this.formInput.product_number);
                    formData.append('product_number_cart' , this.formInput.product_number_cart);
                    formData.append('date1' , this.date1);
                    formData.append('date2' , this.date2);
                    const url = this.$siteUrl+"/admin/add_incredible_offers/"+this.product_id;
                    this.axios.post(url , formData).then(response=>{
                        if(response.data == 'ok'){
                            this.send_form=true;
                            $('#priceBox').modal('hide');
                            this.List.data[this.select_index].offers = 1;
                            this.List.data[this.select_index].price1 = this.formInput.price1;
                            this.List.data[this.select_index].price2 = this.formInput.price2;
                            this.List.data[this.select_index].product_number = this.formInput.product_number;
                            this.List.data[this.select_index].product_number_cart = this.formInput.product_number_cart;
                            this.List.data[this.select_index].offers_first_date = this.date1;
                            this.List.data[this.select_index].offers_last_date = this.date2;
                        }
                        else if(response.data.error=!undefined){
                            // console.log(response.data);
                            this.server_errors=response.data;
                            this.send_form=true;
                        }
                        else{
                            this.server_errors=response.data;
                            this.send_form=true;
                        }
                    });
                }            
            },
            remove_offers : function(item_id , index){
                this.product_id = item_id;
                this.select_index = index;
                this.show_message_box = true;
            },
            remove_of_list : function(){
                this.show_message_box = false;
                const url = this.$siteUrl+"/admin/remove_incredible_offers/"+this.product_id;
                this.axios.post(url).then(response => {
                    if(response.data != 'error'){
                        this.List.data[this.select_index].offers = 0;
                        this.List.data[this.select_index].price1 = response.data.price1;
                        this.List.data[this.select_index].price2 = response.data.price2;
                        this.List.data[this.select_index].product_number = response.data.product_number;
                        this.List.data[this.select_index].product_number_cart = response.data.product_number_cart;
                    }
                });
            },
            validateForm:function ()
            {
                let result=true;
                for(let formInputKey in this.formInput)
                {
                    let  k=formInputKey+"_error";
                    if(this.formInput[formInputKey].toString().trim().length==0)
                    {
                        let message=this.label[formInputKey]+" نمی تواند خالی باشد";
                        this.errors[k]=message;
                        result=false;
                    }
                    else {
                        this.errors[k]=false;
                    }
                }
                return result;
            }
        }
    }
</script>

<style scoped>
.message_box{
    width:450px !important;
}
</style>
