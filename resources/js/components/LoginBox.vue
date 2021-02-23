<template>
    <div class="modal fade" role="dialog" id="login_box">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <div id="auth_box">
                    <div class="auth_box_title">
                      <span>ورود به سایت</span>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div style="margin:25px">
                        <div class="alert alert-warning">
                            ابتدا باید وارد حساب کاربری خود شوید
                        </div>

                        <div class="form-group">
                          <div class="field_name">شماره موبایل</div>
                            <label class="input_label user_name">
                               <input type="text" :class="[mobile_error ? 'form-control validate_error_border' : 'form-control']" v-model="mobile" placeholder="شماره موبایل خود را وارد نمایید">
                               <label class="feedback-hint" v-if="mobile_error">{{ mobile_error_text }}</label>
                            </label>
                        </div>

                        <div class="form-group">
                           <div class="field_name">کلمه عبور</div>
                            <label class="input_label user_pass">
                              <input type="password" :class="[password_error ? 'form-control validate_error_border' : 'form-control']" v-model="password"  placeholder="کلمه عبور خود را وارد نمایید">
                              <label class="feedback-hint" v-if="password_error">{{ password_error_text }}</label>
                            </label>
                        </div>


                       <div class="form-group">
                           <input class="form-check-input" v-model="checked" type="checkbox" >
                           <span :class="[ checked ? 'check_box active' : 'check_box']" v-on:click="checked=!checked"></span>
                           <span class="form-check-label">مرا به خاطر بسپار</span>
                        </div>

                        <div v-if="serverError" class="alert alert-danger">
                            {{ serverError }}
                        </div>
                       <a class="reset_password_link" v-bind:href="$siteUrl+'/password/reset'">بازیابی کلمه عبور</a>

                        <div class="send_btn login_btn" v-on:click="login()">
                          <span class="line"></span>
                          <span class="title">ورود به سایت</span>
                        </div>

                    </div>
                </div>

                <div class="alert alert-warning">
                   <span>کاربر جدید هستید ؟</span>
                   <span>
                    <a class="data_link" v-bind:href="$siteUrl+'/register'">ثبت نام در سایت</a>
                   </span>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    import myMixin from "../myMixin";
    export default({
        name:"LoginBox",
        data(){
            return{
                mobile:'',
                password:'',
                mobile_error:false,
                mobile_error_text:false,
                password_error:false,
                password_error_text:false,
                checked:true,
                serverError:false,
                send_data:true
            }
        },
         mixins:[myMixin],
    })
</script>

<style scoped>

</style>