<style type="text/css">
	.act1 {
    background-color: rgb(38, 39, 39);
    color: #fff;
}
</style>

<?php
$user_type  = $this->session->userdata('user_type');
if(isset($ee1)){ $ee1=$ee1; }else{ $ee1='0'; }
	if(isset($e1)){ $e1=$e1; }else{ $e1='0'; }
	if(isset($e2)){ $e2=$e2; }else{ $e2='0'; }
	if(isset($e3)){ $e3=$e3; }else{ $e3='0'; }
	if(isset($e4)){ $e4=$e4; }else{ $e4='0'; }

if(isset($aa1)){ $aa1=$aa1; }else{ $aa1='0'; }
	if(isset($a1)){ $a1=$a1; }else{ $a1='0'; }
if(isset($bb1)){ $bb1=$bb1; }else{ $bb1='0'; }
	if(isset($b1)){ $b1=$b1; }else{ $b1='0'; }
	if(isset($b2)){ $b2=$b2; }else{ $b2='0'; }
	if(isset($b3)){ $b3=$b3; }else{ $b3='0'; }
	if(isset($b4)){ $b4=$b4; }else{ $b4='0'; }
	if(isset($b5)){ $b5=$b5; }else{ $b5='0'; }
if(isset($cc1)){ $cc1=$cc1; }else{ $cc1='0'; }
	if(isset($c1)){ $c1=$c1; }else{ $c1='0'; }
	if(isset($c5)){ $c5=$c5; }else{ $c5='0'; }
		if(isset($c51)){ $c51=$c51; }else{ $c51='0'; }
		if(isset($c52)){ $c52=$c52; }else{ $c52='0'; }
		if(isset($c53)){ $c53=$c53; }else{ $c53='0'; }
		if(isset($c54)){ $c54=$c54; }else{ $c54='0'; }
		if(isset($c55)){ $c55=$c55; }else{ $c55='0'; }
		if(isset($c56)){ $c56=$c56; }else{ $c56='0'; }
		if(isset($c57)){ $c57=$c57; }else{ $c57='0'; }
	if(isset($c6)){ $c6=$c6; }else{ $c6='0'; }
		if(isset($c61)){ $c61=$c61; }else{ $c61='0'; }
			if(isset($c611)){ $c611=$c611; }else{ $c611='0'; }
			if(isset($c612)){ $c612=$c612; }else{ $c612='0'; }
			if(isset($c613)){ $c613=$c613; }else{ $c613='0'; }
			if(isset($c614)){ $c614=$c614; }else{ $c614='0'; }
		if(isset($c62)){ $c62=$c62; }else{ $c62='0'; }
		if(isset($c63)){ $c63=$c63; }else{ $c63='0'; }
	if(isset($c7)){ $c7=$c7; }else{ $c7='0'; }
		if(isset($c71)){ $c71=$c71; }else{ $c71='0'; }
		if(isset($c72)){ $c72=$c72; }else{ $c72='0'; }
		if(isset($c73)){ $c73=$c73; }else{ $c73='0'; }
		if(isset($c74)){ $c74=$c74; }else{ $c74='0'; }
		if(isset($c75)){ $c75=$c75; }else{ $c75='0'; }
		if(isset($c76)){ $c76=$c76; }else{ $c76='0'; }
		if(isset($c77)){ $c77=$c77; }else{ $c77='0'; }
	if(isset($c8)){ $c8=$c8; }else{ $c8='0'; }
	if(isset($c9)){ $c9=$c9; }else{ $c9='0'; }
	if(isset($c10)){ $c10=$c10; }else{ $c10='0'; }
	if(isset($c11)){ $c11=$c11; }else{ $c11='0'; }
	if(isset($c12)){ $c12=$c12; }else{ $c12='0'; }
	if(isset($c13)){ $c13=$c13; }else{ $c13='0'; }
	if(isset($c14)){ $c14=$c14; }else{ $c14='0'; }

if(isset($c15)){ $c15=$c15; }else{ $c15='0'; }
if(isset($c16)){ $c16=$c16; }else{ $c16='0'; }
if(isset($c17)){ $c17=$c17; }else{ $c17='0'; }
if(isset($c18)){ $c18=$c18; }else{ $c18='0'; }

if(isset($dd1)){ $dd1=$dd1; }else{ $dd1='0'; }
if(isset($d1)){ $d1=$d1; }else{ $d1='0'; }
if(isset($d2)){ $d2=$d2; }else{ $d2='0'; }
if(isset($d3)){ $d3=$d3; }else{ $d3='0'; }
?>

<div class="sidebar sidebar-main sidebar-fixed">
				<div class="sidebar-content">
					<!-- User menu -->

					<!-- /user menu -->

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li>
									<a href="<?= base_url('welcome/consultantdashboard') ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								<!-- <li class="<?= isset($menu_title) && $menu_title == 'Library' ? 'active' : '' ?>">
									<a href="<?= base_url('consultant/library') ?>"><i class="icon-database"></i> <span>Library</span></a></li> -->
								<li class="<?=$ee1?>">
									<a href="#" ><i class="icon-stack2"></i> <span>VERIFICATION</span></a>
									<ul>
										<li class="<?=$e1?>"><a href="<?= base_url('consultant/report') ?>">REPORT</a></li>
										<li class="<?=$e2?>"><a href="<?= base_url('consultant/conduct') ?>">CONDUCT AN INSPECTION</a></li>
										<li class="<?=$e3?>"><a href="<?= base_url('consultant/verification_log') ?>">VIEW DETAILS</a></li>
										<li class="<?=$e4?>"><a href="<?= base_url('consultant/traceability_log') ?>">TRACEABILITY LOG</a></li>
									</ul>
								</li>
								<li class="<?=$aa1?>">
									<a href="#"><i class="icon-stack2" style="height: 50px;"></i>Risk and Opportunities Manage</a>
									<ul>
										<li class="<?=$a1?>"><a href="<?= base_url('consultant/risk_list') ?>">Risk List</a></li>
									</ul>
								</li>
								<li class="<?=$bb1?>">
									<a href="#"><i class="icon-stack2"></i>Corrective Action</a>
									<ul>
										<li class="<?=$b1?>"><a href="<?= base_url('consultant/corrective_action_form') ?>">Corrective Action Form</a></li>
										<li class="<?=$b2?>"><a href="<?= base_url('consultant/corrective_action_report') ?>">Corrective Action Report</a></li>
										<li class="<?=$b3?>"><a href="<?= base_url('consultant/resolution_list') ?>">Corrective Action Resolution Log</a></li>
										<li class="<?=$b4?>">
											<a href="<?= base_url('consultant/resolved_list/CORRECTION') ?>">Monitoring Resolution History</a></li>
										<li class="<?=$b5?>">
											<a href="<?= base_url('consultant/resolved_list/CORRECTIVE') ?>">Resolution log for the monitoring</a></li>
									</ul>
								</li>
								<?php if ($user_type == "consultant"):?>
								<li class="<?=$cc1?>">
									<a href="#"><i class="icon-gear"></i>Manage</a>
									<ul>
										<li class="<?=$c1?>"><a href="<?= base_url(); ?>consultant/employees"><span>Employees</span></a></li>
<!--										<li class="--><?//=$c2?><!--"><a href="--><?php //echo base_url(); ?><!--consultant/process_audit_list"><span>Process Audit Manage</span></a></li>-->
<!--										<li class="--><?//=$c3?><!--"><a href="--><?php //echo base_url(); ?><!--consultant/main_info"><span>Profile</span></a></li>-->
<!--										<li class="--><?//=$c4?><!--"><a href="--><?php //echo base_url(); ?><!--index.php/Auth/update_process"><span> Upgrade Plan</span></a></li>-->
<!--										<li class="--><?//=$c5?><!--"><a href="--><?//=base_url();?><!--consultant/payment_list" >INVOICE</a></li>-->
										<li class="<?=$c5?>">
											<a href="#"></i>Company Info</a>
											<ul>
												<li class="<?=$c51?>"><a href="<?= base_url('consultant/main_info') ?>"><span>Main Info</span></a></li>
												<li class="<?=$c52?>"><a href="<?= base_url('consultant/trigger') ?>"><span>TRIGGER</span></a></li>
												<li class="<?=$c53?>">
													<a href="<?= base_url('consultant/customer_requirement') ?>"><span>CUSTOMER REQUIREMENT</span></a></li>
												<li class="<?=$c55?>">
													<a href="<?= base_url('consultant/regulatory_requirement') ?>"><span>REGULATORY REQUIREMENT</span></a></li>
												<li class="<?=$c56?>">
													<a href="<?= base_url('consultant/policy') ?>"><span>POLICY / PROCEDURE / RECORDS</span></a></li>
												<li class="<?=$c57?>"><a href="<?= base_url('consultant/shift') ?>"><span>shift</span></a></li>
											</ul>
										</li>
										<li class="<?=$c6?>">
											<a href="#"></i>Strategic</a>
											<ul>
												<li class="<?=$c61?>">
													<a href="#">Rating Matrix Manage</a>
													<ul>
														<li class="<?=$c611?>">
															<a href="<?= base_url('') ?>consultant/risks_opportunities"><span>Risks And Opportunities</span></a></li>
														<li class="<?=$c612?>"><a href="<?= base_url('consultant/impact') ?>"><span>Impact</span></a></li>
														<li class="<?=$c613?>">
															<a href="<?= base_url('consultant/risk_values') ?>"><span>Risk Values</span></a>
														</li>
														<li class="<?=$c614?>">
															<a href="<?= base_url('consultant/manage_strategic_rating') ?>"><span>Rating Matrix</span></a></li>
													</ul>
												</li>
												<li class="<?=$c62?>">
													<a href="<?= base_url('consultant/control_actions') ?>"><span>Control Actions</span></a>
												</li>
												<li class="<?=$c63?>">
													<a href="<?= base_url('consultant/assessment_controls') ?>"><span>Assessment Controls</span></a>
												</li>
											</ul>
										</li>
										<li class="<?=$c7?>">
											<a href="#"></i>Operational Rating Matrix Manage</a>
											<ul>
												<li class="<?=$c71?>">
													<a href="<?= base_url('consultant/food_rating') ?>"><span>PARTS Rating Matrix</span></a></li>
												<li class="<?=$c72?>">
													<a href="<?= base_url('consultant/quality_rating') ?>"><span>Quality Rating Matrix</span></a></li>
												<li class="<?=$c73?>">
													<a href="<?= base_url('consultant/environment_rating') ?>"><span>Environment Rating Matrix</span></a></li>
												<li class="<?=$c74?>">
													<a href="<?= base_url('consultant/safety_rating') ?>"><span>Safety Rating Matrix</span></a></li>
												<li class="<?=$c75?>">
													<a href="<?= base_url('consultant/taccp_rating') ?>"><span>Supplier Rating Matrix</span></a></li>
												<li class="<?=$c76?>">
													<a href="<?= base_url('consultant/vaccp_rating') ?>"><span>Others Rating Matrix</span></a></li>
												<li class="<?=$c77?>">
													<a href="<?= base_url('consultant/operational_risk_values') ?>"><span>Risk Values</span></a></li>
											</ul>
										</li>
										<li class="<?=$c8?>"><a href="<?= base_url('consultant/procedure') ?>"><span>Documented Information(Maintained)</span></a></li>
										
										<li class="<?=$c10?>"><a href="<?= base_url('consultant/customer') ?>"><span>Customer</span></a></li>
										<li class="<?=$c11?>"><a href="<?= base_url('consultant/supplier') ?>"><span>Supplier</span></a></li>
										<li class="<?=$c12?>"><a href="<?= base_url('consultant/process') ?>"><span>IMS CORE PROCESS</span></a></li>
										<li class="<?=$c13?>"><a href="<?= base_url('consultant/pre_process') ?>"><span>Support Process</span></a></li>
										<li class="<?=$c14?>">
											<a href="<?= base_url('consultant/additional_process') ?>"><span>Additional Requirements</span></a></li>
										<li class="<?=$c15?>"><a href="<?= base_url('auth/update_process') ?>"><span> Upgrade Plan</span></a></li>
										<li class="<?=$c16?>"><a href="<?= base_url('consultant/payment_list') ?>" >Invoice</a></li>
										<li class="<?=$c54?>"><a href="<?= base_url('consultant/product') ?>"><span>Product or Service</span></a></li>
										<li class="<?=$c9?>">
											<a href="<?= base_url('consultant/record') ?>"><span>Documented Information(Retained)</span></a></li>
										<li class="<?=$c17?>"><a href="<?= base_url('consultant/manage_material')?>" >Material</a></li>
										<li class="<?=$c18?>"><a href="<?= base_url('consultant/manage_machine')?>" >Machine</a></li>

									</ul>
								</li>
								<?php endif;?>
								<li class="<?=$dd1?>">
									<a href="#"><i class="icon-envelope"></i>Inbox</a>
									<ul>
										<li class="<?=$d3?>"><a href="<?= base_url('consultant/control_message') ?>" >Control</a></li>
										<li class="<?=$d1?>"><a href="<?= base_url('consultant/corrective_message') ?>"><span> Corrective Action</span></a></li>
										<li class="<?=$d2?>"><a href="<?= base_url('consultant/individual_message') ?>" >Individual</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<?php $this->load->view('common/update-password-popup'); ?>
