<style>

	label {

		font-size: 13px;

	}



	.help-block > a {

		font-size: 12px;

	}



	.help-block > a:hover {

		box-shadow: none;

		transition: initial;

	}

	small > p {

		color: red;

		font-size: 14px;

		font-weight: bold;

	}

	.content-divider > span {

		background-color: white;

	}



.help-tip{
    position: relative;
    /*top: 18px;
    right: 18px;*/
    text-align: center;
    background-color: #BCDBEA;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 14px;
    line-height: 26px;
    cursor: default;
}

.help-tip:before{
    content:'?';
    font-weight: bold;
    color:#fff;
}

.help-tip:hover p{
    display:block;
    transform-origin: 100% 0%;

    -webkit-animation: fadeIn 0.3s ease-in-out;
    animation: fadeIn 0.3s ease-in-out;

}

.help-tip p {
    display: none;
    text-align: left;
    background-color: #1E2021;
    padding: 15px;
    width: 300px;
    position: absolute;
    border-radius: 3px;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
    right: -4px;
    color: #FFF;
    font-size: 12px;
    line-height: 25px;
    z-index: 99;
}

.help-tip p:before{ /* The pointer of the tooltip */
    position: absolute;
    content: '';
    width:0;
    height: 0;
    border:6px solid transparent;
    border-bottom-color:#1E2021;
    right:10px;
    top:-12px;
}

.help-tip p:after{ /* Prevents the tooltip from being hidden */
    width:100%;
    height:40px;
    content:'';
    position: absolute;
    top:-40px;
    left:0;
}

/* CSS animation */

@-webkit-keyframes fadeIn {
    0% { 
        opacity:0; 
        transform: scale(0.6);
    }

    100% {
        opacity:100%;
        transform: scale(1);
    }
}

@keyframes fadeIn {
    0% { opacity:0; }
    100% { opacity:100%; }
}

.form-group.float-right {
    float: right;
    margin: -33px 5px 0px 0px;
    position: relative;
    /* top: 37px; */
}

</style>



<section class="LoginBox">

	<form name="login_form" class="wow zoomIn" action="<?= base_url('auth/register') ?>" method="post">

		<div class="login-form">

			<div class="text-center">

				<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>

				<h5 class="content-group-lg">Create account

					<small class="display-block">

						<?= validation_errors() ?>

					</small>

				</h5>

			</div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="text" value="<?= set_value('register[consultant_name]') ?>" class="form-control input-lg" placeholder="Company Name" name="register[consultant_name]">

				<div class="form-control-feedback">

					<i class="icon-home text-muted"></i>

				</div>

			</div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="email" value="<?= set_value('register[email]') ?>" class="form-control input-lg" placeholder="Email" name="register[email]">

				<div class="form-control-feedback">

					<i class="icon-mail5 text-muted"></i>

				</div>

			</div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="text" value="<?= set_value('register[username]') ?>" class="form-control input-lg" placeholder="Username" name="register[username]">

				<div class="form-control-feedback">

					<i class="icon-user text-muted"></i>

				</div>

			</div>



			<div class="form-group has-feedback has-feedback-left">

				<input type="password" class="form-control input-lg" placeholder="Password" value="<?= set_value('register[password]') ?>"  name="register[password]">

				<div class="form-control-feedback">

					<i class="icon-lock2 text-muted"></i>

				</div>

	            <div class="form-group float-right">
	                <div class="help-tip">
	                    <p>Must include at least 8 chracters <br/>Must include at least 1 uppercase letter(A-Z) <br/>Must include at least 1 lowercase letter(a-z) <br/>Must include at least 1 numeric digit(0-9) <br/>Must include at least 1 special character(!@#$%^*)</p>
	                </div>
	            </div>

			</div>
            <div class="form-group has-feedback has-feedback-left">

                <input type="text" class="form-control input-lg" placeholder="Mobile Number" value="<?= set_value('register[phone]') ?>"  name="register[phone]">

                <div class="form-control-feedback">

                    <i class="icon-mobile text-muted"></i>

                </div>

                <div class="form-group float-right">
                    <div class="help-tip">
                        <p>Must Be in International Format <br/> Only Mobile Number Accepted</p>
                    </div>
                </div>

            </div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="password" value="<?= set_value('register[repassword]') ?>" class="form-control input-lg" placeholder="Retype Password" name="register[repassword]">

				<div class="form-control-feedback">

					<i class="icon-lock2 text-muted"></i>

				</div>

			</div>

			<!-- <div class="form-group">

				<script src='https://www.google.com/recaptcha/api.js'></script>

				<div class="g-recaptcha" data-sitekey="6LeMZPkUAAAAAOY59BjLyKtYXFOH3YU4QNGKWSw4"></div> 
				<div id="errormessage" style="color: red; margin: 5px 0 0 0px" ></div> 
			</div> -->


			<div class="form-group">

				<a href="javascript:signup()"   class="btn bg-blue btn-block btn-lg">Register <i class="icon-arrow-right14 position-right"></i></a>

			</div>

			<div class="content-divider text-muted form-group"><span>Already have an account?</span></div>

			<a href="<?= base_url('auth/login') ?>" class="btn bg-slate btn-block btn-lg content-group">Login</a>

			<span class="help-block text-center">

				By continuing, you're confirming that you've read and agree to our <a target="_blank" href="<?php echo base_url("index.php/auth/terms")?>">Terms and Conditions</a> and <a target="_blank" href="<?php echo base_url("index.php/auth/terms")?>">Cookie Policy</a>

			</span>

		</div>

	</form>

</section>

<script type="text/javascript">
	function signup(argument) {
		// if(grecaptcha.getResponse() == "") { 
  //                jQuery("#errormessage").text("Please Fill The Google Captcha");
  //             }
  //             else{
              			document.login_form.submit();
              // } 
	}
</script>