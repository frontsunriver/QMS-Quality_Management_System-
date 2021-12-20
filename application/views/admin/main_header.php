<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"><img src="<?=base_url(); ?>assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				
			</ul>

		

			<ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-user" >
                    <div class="mt-5">
                        <input type="checkbox" data-toggle="toggle" <?= ($this->settings->otp_verification) ? 'checked' : '' ?> data-style="ios" data-id="0" class="otp-active-deactive" data-on="OTP Active" data-off="OTP De-active">
                    </div>
                </li>
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
					
						<span>
							<?php
							if ($admin=$this->session->userdata('admin_id')) {
								echo $admin=$this->session->userdata('username');
							}
							?>
						</span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo base_url(); ?>index.php/Admin/edit_profile"><i class="icon-user-plus"></i> Edit profile</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/Admin/default_logo"><i class="icon-image4"></i>Default Logo</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/Welcome/logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>