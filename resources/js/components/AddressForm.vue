<template>
    <div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">
                            <span class="fa fa-location-arrow"></span>
                            <span>{{ title }}</span>
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="add_address_box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="account_title">نام و نام خانوادگی تحویل گیرنده</div>
                                                <label class="input_label">
                                                    <input type="text" v-model="name" class="form-control" placeholder="نام و نام خانوادگی تحویل گیرنده">
                                                    <label v-if="error_name_message" :class="[error_name_message ? 'feedback-hint active' : 'feedback']">{{ error_name_message }}</label>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="account_title">شماره موبایل</div>
                                                <label class="input_label">
                                                    <input type="text" v-model="mobile" class="form-control" placeholder="شماره موبایل">
                                                    <label v-if="error_mobile_message" :class="[error_mobile_message ? 'feedback-hint active' : 'feedback']">{{ error_mobile_message }}</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="account_title">استان</div>
                                                <label class="input_label">
                                                    <select class="selectpicker" v-model="province_id" id="province_id" v-on:change="getCity('')">
                                                        <option value="">انتخاب استان</option>
                                                        <option v-for="row in province"  v-bind:value="row.id">{{ row.name }}</option>
                                                    </select>
                                                    <label v-if="error_province_id_message" :class="[error_province_id_message ? 'feedback-hint active' : 'feedback']">{{ error_province_id_message }}</label>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="account_title">شهر</div>
                                                <label class="input_label">
                                                    <select class="selectpicker" v-model="city_id" id="city_id">
                                                        <option value="">انتخاب شهر</option>
                                                        <option v-for="row in city" v-bind:value="row.id">{{ row.name }}</option>
                                                    </select>
                                                    <label v-if="error_city_id_message" :class="[error_city_id_message ? 'feedback-hint active' : 'feedback']">{{ error_city_id_message }}</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="account_title">آدرس پستی</div>
                                                <label class="input_label">
                                                    <textarea class="textArea" v-model="address" placeholder="آدرس تحویل گیرنده را وارد نمایید"></textarea>
                                                    <label v-if="error_address_message" :class="[error_address_message ? 'feedback-hint active' : 'feedback']">{{ error_address_message }}</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="account_title">کد پستی</div>
                                                <label class="input_label">
                                                    <input type="text" v-model="zip_code" class="form-control" placeholder="کد پستی">
                                                    <label v-if="error_zip_code_message" :class="[error_zip_code_message ? 'feedback-hint active' : 'feedback']">{{ error_zip_code_message }}</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button class="btn btn-primary" v-on:click="add_address()">
                                                    <span>ثبت و ارسال به این آدرس</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import myMixin from '../myMixin';
export default {
    name:"AddressForm",
    data(){
        return{
            id:0,
            name:'',
            mobile:'',
            province_id:'',
            city_id:'',
            address:'',
            zip_code:'',
            error_name_message:false,
            error_mobile_message:false,
            error_province_id_message:false,
            error_city_id_message:false,
            error_address_message:false,
            error_zip_code_message:false,
            province:[],
            city:[],
            title:'افزودن آدرس جدید',
            // btn_text:'ثبت و ارسال به این آدرس',
            // server_error:false,
            get_page:'no'
        }
    },
    mixins:[myMixin],
    props:['paginate'],
    mounted() {
        this.getProvince();
        this.get_page=this.paginate=='ok' ? 'ok' : 'no';
    },
    methods:{
        getProvince()
        {
            this.axios.get(this.$siteUrl+'/api/get_province').then(response=>{
                this.province=response.data;
                setTimeout(function () {
                    $("#province_id").selectpicker('refresh');
                },100)
            });
        },
        getCity:function (id) {
            if(this.province_id!='')
            {
                this.city_id=id;
                this.city=[];
                this.axios.get(this.$siteUrl+'/api/get_city/'+this.province_id).then(response=>{
                    this.city=response.data;
                    setTimeout(function () {
                        $("#city_id").selectpicker('refresh');
                    },100)
                });
            }
        },
        add_address:function () {
            const validateName=this.validateName();
            const validateMobileNumber=this.validateMobileNumber();
            const validateAddress=this.validateAddress();
            const validateZipCode=this.validateZipCode();
            const validateProvince=this.validateProvince();
            const validateCity=this.validateCity();

            if(validateName && validateMobileNumber && validateAddress && validateZipCode && validateProvince && validateCity)
            {
                $("#loading_box").show();

                const formData=new FormData();
                formData.append('id',this.id);
                formData.append('name',this.name);
                formData.append('mobile',this.mobile);
                formData.append('address',this.address);
                formData.append('zip_code',this.zip_code);
                formData.append('city_id',this.city_id);
                formData.append('province_id',this.province_id);
                formData.append('paginate',this.get_page);
                const url=this.$siteUrl+'/user/addAddress';
                // this.server_error=false;
                this.axios.post(url,formData).then(response=>{
                    $("#loading_box").hide();
                    if(response.data!="error")
                    {
                        this.$emit('setData',response.data);
                        $("#myModal").modal('hide');
                    }
                    // else {
                    //     this.server_error=true;
                    // }
                }).catch(error=>{
                    $("#loading_box").hide();
                    // this.server_error=true;
                });
            }
        },
        validateName:function () {
            if(this.name.toString().trim()=="")
            {
                this.error_name_message='نام و نام خانوادگی نمی تواند خالی باشد';
                return false;
            }
            else if(this.name.toString().trim().length<6)
            {
                this.error_name_message='نام و نام خانوادگی حداقل باید شامل ۶ کاراکتر باشد';
                return false;
            }
            else{
                this.error_name_message=false;
                return  true;
            }
        },
        validateMobileNumber:function () {
            if(this.mobile.toString().trim()=="")
            {
                this.error_mobile_message='لطفا شماره موبایل خود را وارد نمایید';
                return false;
            }
            else if(this.check_mobile_number())
            {
                this.error_mobile_message='شماره موبایل وارد شده معتبر نمی باشد';
                return false;
            }
            else{
                this.error_mobile_message=false;
                return  true;
            }
        },
        validateAddress:function () {
            if(this.address.toString().trim()=="")
            {
                this.error_address_message='آدرس نمی تواند خالی باشد';
                return false;
            }
            else if(this.address.toString().trim().length<20)
            {
                this.error_address_message='آدرس وارد شده کوتاه است';
                return false;
            }
            else{
                this.error_address_message=false;
                return  true;
            }
        },
        validateZipCode:function () {
            if(this.zip_code.toString().trim()=="")
            {
                this.error_zip_code_message='کد پستی نمی تواند خالی باشد';
                return false;
            }
            else if(this.zip_code.toString().trim().length<10 || isNaN(this.zip_code) || this.zip_code.toString().trim().length>10)
            {
                this.error_zip_code_message='کد پستی معتبر نمی باشد';
                return false;
            }
            else{
                this.error_zip_code_message=false;
                return  true;
            }
        },
        validateProvince:function () {
            if(this.province_id.toString().trim()=="")
            {
                this.error_province_id_message='لطفا استان را انتخاب کنید';
                return false;
            }
            else{
                this.error_province_id_message=false;
                return  true;
            }
        },
        validateCity:function () {
            if(this.city_id.toString().trim()=="")
            {
                this.error_city_id_message='لطفا شهر را انتخاب کنید';
                return false;
            }
            else{
                this.error_city_id_message=false;
                return  true;
            }
        },
        setUpdateData:function (address , title) {
            // this.btn_text='ویرایش';
            this.id=address.id;
            this.name=address.name;
            this.mobile=address.mobile;
            this.city_id=address.city_id;
            this.province_id=address.province_id;
            this.address=address.address;
            this.zip_code=address.zip_code;
            this.title=title;
            this.getProvince();
            if(this.province_id>0){
                this.getCity(this.city_id);
            }
            else{
                this.cityList=[];
                setTimeout(function () {
                    $("#city_id").selectpicker('refresh');
                },100);
            }
            this.error_name_message=false;
            this.error_mobile_message=false;
            this.error_address_message=false;
            this.error_zip_code_message=false;
            this.error_province_id_message=false;
            this.error_city_id_message=false;
            $("#myModal").modal('show');
        },
        setTitle:function (title) {
            this.title=title;
            this.id='';
            this.name='';
            this.mobile='';
            this.city_id='';
            this.province_id='';
            this.address='';
            this.zip_code='';
            // this.btn_text='ثبت و ارسال به این آدرس';
        }
    }
}
</script>