<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href=""><img src="<?=base_url(); ?>assets/images/logo_light.png" alt=""></a>

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
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						
						<span>
							<?php
							if ($this->session->userdata('consultant_id')) {
								echo $this->session->userdata('username');
							}
							?>
						</span>
						<i class="caret"></i>
					</a>
					<?php $user_type = $this->session->userdata('user_type');?>
					<ul class="dropdown-menu dropdown-menu-right">
						<?php if ($user_type == "consultant"): ?>
							<li><a href="<?=base_url();?>index.php/consultant/main_info"><i class="icon-user-plus"></i> Edit profile</a></li>
						<?php else:?>
							<li><a href="<?=base_url();?>index.php/consultant/edit_profile"><i class="icon-user-plus"></i> My profile</a></li>
						<?php endif;?>
						<li class="divider"></li>
						<li><a href="<?php echo base_url(); ?>index.php/Welcome/logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>