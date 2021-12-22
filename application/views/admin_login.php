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

.custom-capcha {
    width: 100%;
    float: left;
    margin-top: 10px;
    margin-bottom: 20px;
}

.LoginBox.custom-light form#login_form {
    width: 100% !important;
    max-width: 400px !important;
    margin: auto;
}

@media(max-width: 767px;){
.custom-capcha .rc-anchor-normal .rc-anchor-pt {
    padding-right: 30px !important; 
}

.custom-capcha iframe {
    width: 100% !important;
    float: left;
}
.custom-capcha .g-recaptcha div:nth-child(1) {
    width: auto !important;
    height: auto !important;
    float: left;
}
.navbar.navbar-inverse .navbar-header{
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}
    /*=-=- shift card design =-=-*/
    .shift-card-holder {
        position: relative;
        width: 100%;
    }
    .shift-card-holder .shift-card-input {
        display: none;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card {
        color: white;
        background-color: #607d8b;
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
        background-color: #607d8b;
        left: 10px;
        top: 3px;
    }
    .shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login_kick {
        position: absolute;
        width: 7px;
        height: 2px;
        background-color: #607d8b;
        left: 5px;
        top: 13px;
    }
    /*.shift-card-holder .shift-card-input:checked + .shift-card .checkmark-login.r-t {
        right: 15px;
        top: 10%;
        left: initial;
    }*/
    .shift-card-holder .shift-card {
        background: #607d8b;
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
        border-radius: 3px;
        height: 40px;
    }
    .shift-card-holder .shift-card .shift-card:hover {
        box-shadow: 0 0 6px #4183d7;
    }
    .login-object{
        display: flex;
        justify-content: center;
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
</style>

<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>

<section class="LoginBox custom-light">

	<form class="wow zoomIn" id="login_form" action="<?= $otp_status ? base_url('auth/verifyMethod'):base_url('auth/adminauth') ?>" method="post">

		<div class="login-form">

			<div class="text-center">

				<div class="">
					<img src="<?= base_url(IMG_URL . 'logo_login.png') ?>" alt="" style="width:175px;">
				</div>

				<h5 class="content-group-lg">Login to your account

					<small class="display-block">

						<?= validation_errors() ?>

						<?= isset($flash) ? "<p>{$flash['msg']}</p>" : '' ?>

                        <?= $this->login_limit->draw_timer() ?>

					</small>

				</h5>

			</div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="text" class="form-control input-lg" name="login[username]" placeholder="Username" />

				<div class="form-control-feedback">

					<i class="icon-user text-muted"></i>

				</div>

			</div>

			<div class="form-group has-feedback has-feedback-left">

				<input type="password" id="password" data-toggle="password" class="form-control input-lg" name="login[password]" placeholder="Password" />

				<div class="form-control-feedback">

					<i class="icon-lock2 text-muted"></i>

				</div>

			</div>

			<div class="form-group login-options">

				<div class="row">

					<div class="col-sm-6">

						<label class="checkbox-inline">

							<input type="checkbox" class="styled" checked="checked" />Remember

						</label>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="radio" style="margin-top: 0px;">

						<label>

							<input type="radio" name="usertype" class="control-custom" value="admin" checked />

								Super Admin

						</label>

					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-warning" value="consultant" />

							Admin

						</label>

					</div>

					<!-- <div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-warning" value="executive" checked/>

							Executive

						</label>

					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="process_owner" />

							Process Owner/SME

						</label>

					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="employee" />

							Risk Monitor

						</label>

					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="monitor" />

							Production Manager/Monitor/Supervisor

						</label>

					</div> -->

					<!-- <div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="inspector" />

							Inspector/Monitor

						</label>

					</div> -->

					<!-- <div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="procurement" />

							Procurement

						</label>

					</div>

					<div class="radio">
						<label>
							<input type="radio" name="usertype" class="control-info" value="warehousing" />
							Warehousing
						</label>
					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="sales" />

							Sales

						</label>

					</div>

					<div class="radio">

						<label>

							<input type="radio" name="usertype" class="control-info" value="manufacturing" />

							Manufacturing

						</label>

					</div> -->
					<!-- <div class="custom-capcha">
						<script src='https://www.google.com/recaptcha/api.js'></script> 
						<div class="g-recaptcha" data-sitekey="6LeMZPkUAAAAAOY59BjLyKtYXFOH3YU4QNGKWSw4"></div> 
						<div id="errormessage"></div> 
					</div> -->
				</div>
				

			</div>
			<div class="form-group">

				<a href="javascript:login()" class="btn bg-slate btn-block btn-lg content-group">Login <i class="icon-arrow-right14 position-right"></i></a>

			</div>
		</div>

	</form>

</section>



<script>
	
	function login() {
		// if(grecaptcha.getResponse() == "") 
		// { 
		// 	jQuery("#errormessage").text("Please Fill The Google Captcha");
		// }
		// else
		// {
			$("#login_form").submit();
		// } 

	}
	$(function() {
		$("#password").password('toggle');
		$(".styled").uniform();
	});
</script>