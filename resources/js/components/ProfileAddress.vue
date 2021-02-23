<template>
        <div>
           <button type="button" class="add_address_btn profile_address_btn" v-on:click="showModalBox()" data-target=".bd-example-modal-lg">
               ایجاد آدرس جدید   
           </button>

           <div class="profile-address-cart" v-for="(address,key) in  AddressLists.data" v-bind:key="address.id">
              <div class="profile-address-cart-desc">
                 <h4>{{ address['name'] }}</h4>
                 <p>{{ address['address']}}</p>
              </div>  
              <div class="profile-address-cart-data">
                 <ul>
                     <li>
                        <span class="fa fa-envelope"></span>
                        <span>کد پستی :‌ {{ address['zip_code'] }}</span>
                     </li>
                     <li>
                        <span class="fa fa-mobile-phone"></span>
                        <span>تلفن همراه : {{ address['mobile'] }}</span>
                     </li>
                 </ul>
                 <ul style="display:inline-flex" class="btn_ul">
                    <li>
                        <button class="address_btn" v-on:click="updateRow(address)">ویرایش</button>
                    </li>
                    <li style="margin-right:10px">
                        <button class="address_btn" v-on:click="remove_address(address)">حذف</button>
                    </li>
                </ul>
              </div>
           </div>

          <pagination :data="AddressLists" @pagination-change-page="getAddress"></pagination>

          <address-form @setData="updateAddressList" ref="data" :paginate="'ok'"></address-form>

            <div class="message_div" v-if="show_dialog_box">
               <div class="message_box">
                  <p id="msg">آیا مطمئنید که این آدرس حذف شود؟</p>
                  <a class="alert alert-success" v-on:click="delete_address('ok')">بله</a>
                  <a class="alert alert-danger" v-on:click="show_dialog_box=false">خیر</a>
               </div>
            </div>
        </div>

</template>

<script>
import myMixin from "../myMixin";
import AddressForm from './AddressForm';
 export default {
        name: "ProfileAddress",
        components:{AddressForm},
        mixins:[myMixin],
        props:['layout'],
        data(){
            return {
                AddressLists:{data:[]},
                show_dialog_box:false
            }
        },
        mounted() {
           this.getAddress();
        },
        methods:{
            getAddress:function(page=1){
                const url=this.$siteUrl+"/user/getAddreass?page="+page;
                this.axios.get(url).then(response=>{
                    this.AddressLists=response.data;
                });
            },
            updateAddressList:function (data) {
                 this.AddressLists=data;
            },
        }
 }
</script>