<style type="text/css">
    /*=-=- shift card design =-=-*/
    .shift-card-holder {
        position: relative;
        width: 100%;
    }
    .shift-card-holder .shift-card-input {
        display: none;
    }
    .shift-card-holder .shift-card-input:disabled + .shift-card {
        opacity: 0.8;
        cursor: not-allowed;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card {
        color: white;
        background-image: linear-gradient(#7575ed, #925cf2);
    }
    .shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login {
        display: inline-block;
        width: 18px;
        height: 18px;
        -ms-transform: rotate(45deg);
        /* IE 9 */
        -webkit-transform: rotate(45deg);
        /* Chrome, Safari, Opera */
        transform: rotate(45deg);
        position: absolute;
        right: 5px;
        top: 5px;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login_circle {
        position: absolute;
        width: 18px;
        height: 18px;
        background-color: #fff;
        border-radius: 11px;
        left: 0;
        top: 0;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login_stem {
        position: absolute;
        width: 2px;
        height: 11px;
        background-image: linear-gradient(#7575ed, #925cf2);
        left: 10px;
        top: 3px;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login_kick {
        position: absolute;
        width: 7px;
        height: 2px;
        background-image: linear-gradient(#7575ed, #925cf2);
        left: 5px;
        top: 13px;
    }
    /*.shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login.r-t {
        right: 15px;
        top: 10%;
        left: initial;
    }*/
    .shift-card-holder .shift-card {
        background: linear-gradient(#7575ed, #925cf2);
        transition: all 0.5s ease-out;
        color: #fff;
        padding: 10px 0;
        font-size: 15px;
        line-height: 30px;
        width: 100%;
        text-align: center;
        margin-bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .shift-card-holder .shift-card .shift-card:hover {
        box-shadow: 0 0 6px #4183d7;
    }


    .radio>label{font-size: 13px!important}
    .divider-with-text {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }
    .divider-with-text::before {
        content: "";
        height: 1px;
        background: rgba(0, 0, 0, 0.10);
        flex: 1;
        margin-right: 10px;
        margin-top: 4px;
    }
    .divider-with-text::after {
        content: "";
        height: 1px;
        background: rgba(0, 0, 0, 0.10);
        flex: 1;
        margin-left: 10px;
        margin-top: 4px;
    }
    .login-object{
        display: flex;
        justify-content: center;
        width: 100%;
        margin: 0 auto 10px;
    }
    .login-object .box-text{
        margin: 0;
        font-size: 18px;
        font-weight: 500;
    }
    .mr-3{
        margin-right: 1rem;
    }
    .login-object .box-text span{
        color: #fff;
    }
    .LoginInner button{
        background-image: linear-gradient(#7575ed, #925cf2);
        width: 100%;
        display: block;
        padding: 8px;
        font-size: 21px;
        margin: auto;
        color: #fff;
        font-weight: 500;
        margin-bottom: 20px;
        border: 0;
    }
    .LoginInner{padding: 0}
</style>

<section class="LoginBox">
   <form name="login_form" action="<?php echo base_url('auth/verification'); ?>" method="post">
	   	<div class="LoginInner wow zoomIn">
		    <div class="form-group">
			     <div class="col-sm-12 LoginImg">
					  <img src="<?php echo base_url('assets/images/home/userimg.png'); ?>">
					  <small class="display-block" style="display: block;margin-top: 3px;color: red;font-weight:700;font-size:20px;">
					    <?php echo validation_errors();
			                   if ($this->session->flashdata('message')) {
			                    echo $this->session->flashdata('message');
			                   }
					    ?>
					  </small>
			     </div>
                <input type="hidden" name="login[username]" value="<?=$username?>">
                <input type="hidden" name="login[password]" value="<?=$password?>">
                <input type="hidden" name="usertype" value="<?=$user_type?>">
		    </div>
            <div class="">
                <p class="divider-with-text text-muted text-center">Choose Your Verification Method</p>
            </div>

            <div class="login-object">
                <div class="shift-card-holder mr-3">
                    <input class="show-hide-toggle shift-card-input" id="via_email" type="radio" name="verification_method" value="email" <?=(!$otp_status['email'] ? 'disabled':'')?> required>
                    <label for="via_email" class="shift-card input-placeholder">
                           <span class="checkmark-login r-t">
                               <div class="checkmark-login_circle"></div>
                               <div class="checkmark-login_stem"></div>
                               <div class="checkmark-login_kick"></div>
                           </span>
                        <div class="d-flex align-items-center m-2">
                            <div class="shift-name text-left ml-sm-3">
                                <h3 class="box-text ak-semi-bold">
                                    <i class="fa fa-envelope icon-size-lg"></i>
                                    <span class="small">Email Address</span>
                                </h3>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="shift-card-holder">
                    <input class="show-hide-toggle shift-card-input" id="via_mobile" type="radio" name="verification_method" value="phone" <?=(!$otp_status['phone'] ? 'disabled':'')?> required>
                    <label for="via_mobile" class="shift-card input-placeholder">
                           <span class="checkmark-login r-t">
                               <div class="checkmark-login_circle"></div>
                               <div class="checkmark-login_stem"></div>
                               <div class="checkmark-login_kick"></div>
                           </span>
                        <div class="d-flex align-items-center m-2">
                            <div class="shift-name text-left ml-sm-3">
                                <h3 class="box-text ak-semi-bold">
                                    <i class="fa fa-comment icon-size-lg"></i>
                                    <span class="small">Phone Number</span>
                                </h3>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <button type="submit" class="hvr-bounce-in"> Login </button>
	   </div><!--LoginInner-->
   </form>
</section><!--LoginBox-->
<script type="text/javascript">
	$("#password").password('toggle');
</script>
<script type="text/javascript">
function login(){
    
if(grecaptcha.getResponse() == "") { 
                 jQuery("#errormessage").text("Please Fill The Google Captcha");
              }
              else{
              			document.login_form.submit();
              } 

}
</script>