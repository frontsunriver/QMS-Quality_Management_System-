<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
<!--    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
    <link href="<?= base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>assets/css/jqx.base.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/plugins/tables/datatables/datatables.min.js"></script>-->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxcore.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxdata.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxbuttons.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxdropdownbutton.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxscrollbar.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxpanel.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jqxtree.js"></script>
<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->

</head>
<body class="navbar-top">


	<!-- Main navbar -->
<?php $this->load->view('consultant/main_header.php'); ?>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('consultant/sidebar'); ?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-default">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><?php
                            if ($this->session->userdata('consultant_id')) {
                                $consultant_id = $this->session->userdata('consultant_id');
                                $audito1 = $this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

                                $dlogo = $this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

                                if ($audito1->logo == '1') {
                                    $audito = $dlogo;
                                } else {
                                    $audito = $audito1->logo;
                                }
                            }
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?= $audito ?>" style="height:50px;">
                            <span class="text-semibold"><?= $title ?></span>

                            <div class="pull-right">
                                <?php
                                /*                                $consultant_id = $this->session->userdata('consultant_id');
                                                                $plan_ids1 = @$this->db->query("select * from upgrad_plan where `consultant_id`='$consultant_id' AND `status`='1'")->row()->plan_id;
                                                                if (count($plan_ids1) > 0) {
                                                                    $d1 = @$this->db->query("select * from plan where `plan_id`='$plan_ids1'")->row()->no_of_user;
                                                                }
                                                                $d2 = @$this->db->query("select * from plan order by no_of_user DESC")->row()->plan_id;
                                                                */?><!--
                                <?php /*if ($d1 != $d2 && $d2 > $d1) { */?>
                                    <a href="<?php /*echo base_url(); */?>index.php/Auth/update_process"
                                       class="btn bg-brown"> <i class="icon-wrench" title="Main pages"></i> <span> Upgrade Plan</span></a>
                                --><?php /*} */?>
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i
                                    class="icon-home2 role-left"></i>Home</a></li>
                        <li><a href="#"><?= $title ?></a></li>

                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<!-- Form horizontal -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><?=$title?></h5>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" action="<?php echo  base_url(); ?>index.php/consultant/add_corrective_action_data" enctype="multipart/form-data">
								<input type="hidden" id = "monitoring_id" name="monitoring_id" value="<?=$monitoring_id?>">
								<!--<fieldset>
									<div class="row" style="margin-top: 24px;">

										<div class="col-md-6" >
											<span class="help-block">Type of Monitoring:</span>

											<select name="monitoring_type" id="monitoring_type" class="form-control ">
												<?php /*foreach ($monitoring_type as $item) { */?>
													<option  value="<?/*=$item->type_id*/?>"><?/*=$item->type_of_monitoring*/?></option>
												<?php /*} */?>
											</select>
										</div>
										<div class="col-md-6">
											<span class="help-block">Process:</span>

											<select name="process" id="process" class="form-control">
												<?php /*foreach ($process as $item) { */?>
													<option  value="<?/*=$item->id*/?>" <?php /*if ($selected_item->process_name == $item->name): */?>selected<?php /*endif; */?>><?/*=$item->name*/?></option>
												<?php /*} */?>
											</select>
										</div>
									</div>
								</fieldset>-->

								<fieldset class="content-group">

									<legend class="text-bold"></legend>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-4">
												    <span class="help-block">Line Worker:</span>
													   <select name="line_worker" class="form-control " required>
						                                    <option value="0">TBD</option>
						                                    <option value="-1">N/A</option>
						                                     <?php foreach ($employees as $employee) { ?>
						                                       <option value="<?=$employee->employee_id?>"><?=$employee->employee_name?></option>
						                                     <?php } ?>
													   </select>
												</div>

												<div class="col-md-4">
											    	<span class="help-block">TRIGGER:</span>
													<div class="col-md-8">
													 	<select class="form-control" name="trigger_id" id="trigger" required>
													    </select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#triggers" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
												<div class="col-md-4">
													<span class="help-block">CUSTOMER REQUIREMENT:</span>
													<div class="col-md-8">
														<select class="form-control" name="customer_requirment" id="customer_requirment" required>
														</select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#customer_requirments" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-4">
											    	<span class="help-block">DATE OF OCCURRANCE:</span>
													<input type="date" class="form-control" name="occur_date" value="<?=date('Y-m-d');?>" required>
												</div>
												<div class="col-md-4">
													<span class="help-block">PRODUCT :</span>
													<div class="col-md-8">
														<select class="form-control" name="product" id="product" required>
														</select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#products" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
												<div class="col-md-4">
													<span class="help-block">Process Step :</span>
													<div class="col-md-8">
														<select class="form-control" name="process_step" id="process_step" required>
														</select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#process_steps" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
											    <div class="col-md-4">
											    	<span class="help-block">REGULATORY REQUIREMENT:</span>
													 <div class="col-md-8">
													 	<select class="form-control" name="regulatory_requirement" id="regulatory_requirement" required>
													    </select>
													 </div>
													 <div class="col-md-4">
													 	<a data-toggle="modal" data-target="#regulatory_requirements" class="btn btn-primary">MANAGE</a>
													 </div>
												</div>
												<div class="col-md-4">
													<span class="help-block">POLICY/PROCEDURE/RECORDS:</span>
													<div class="col-md-8">
														<select class="form-control" name="policy" id="policy" required>
														</select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#policys" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
												<div class="col-md-4">
													<span class="help-block">MACHINE:</span>
													<div class="col-md-8">
														<select class="form-control" name="mashine_clause" id="mashines" required>
														</select>
													</div>
													<div class="col-md-4">
														<a data-toggle="modal" data-target="#mashine" class="btn btn-primary">MANAGE</a>
													</div>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
											    <div class="col-md-4">
											    	<span class="help-block">SHIFT:</span>
													 <div class="col-md-8">
													 	<select class="form-control" name="shift" id="shift" required>
													    </select>
													 </div>
													 <div class="col-md-4">
													 	<a data-toggle="modal" data-target="#shifts" class="btn btn-primary">MANAGE</a>
													 </div>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-12">
											    	<span class="help-block">DESCRIPTION OF PROBLEM / NONCONFORMITY:</span>
													<textarea class="form-control" name="prob_desc" required><?=$selected_item->note?></textarea>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-6">
											    	<span class="help-block">CORRECTION:</span>
													<textarea class="form-control" name="correction" required>TBD</textarea>
												</div>
												<div class="col-md-6">
											    	<span class="help-block">Grade of Non-conformity:</span>
													<textarea class="form-control" name="business_impact" required></textarea>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-6">
											    	<span class="help-block">ROOT CAUSE:</span>
													<textarea class="form-control" name="root_cause" required>TBD</textarea>
													<input type="file" name="root_doc">
												</div>
												<div class="col-md-6">
											    	<span class="help-block">CORRECTIVE  ACTION PLAN:</span>
													<textarea class="form-control" name="action_plan" required>TBD</textarea>
													<input type="file" name="corrective_plan_doc">
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-6">
											    	<span class="help-block">CORRECTIVE ACTION:</span>
													<textarea class="form-control" name="corrective_action" required>TBD</textarea>
												  <input type="file" name="corrective_doc">
												</div>
												<div class="col-md-6">
											    	<span class="help-block">Verification of Effectiveness </span>
													<textarea class="form-control" name="verification_effectiveness" required>TBD</textarea>
													<input type="file" name="verification_doc">
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-6">
											    	<span class="help-block">TYPE:</span>
												    	<select name="type" class="form-control " required>
						                                    <option value="CORRECTIVE">CORRECTIVE</option>
						                                    <option value="CORRECTION">CORRECTION</option>
						                                </select>
												</div>
												<div class="col-md-6">
											    	<span class="help-block">BY WHEN DATE:</span>
													<input type="date" name="by_when_date" value="<?=date('Y-m-d')?>" class="form-control" required>
												</div>
											</div>
											<div class="row" style="margin-top: 24px;">
												<div class="col-md-6">
											    	<span class="help-block">Process Owner:</span>
													    <select name="responsible_party" class="form-control" onchange="findresponsible(this.value);" required>
						                                     <?php foreach ($employees as $employee) { ?>
						                                       <option value="<?=$employee->employee_id?>" <?php if ($selected_item->process_owner == $employee->employee_id): ?>selected<?php endif; ?>><?=$employee->employee_name?></option>
						                                     <?php } ?>
						                                </select>
												</div>
												<div class="col-md-6">
											    	<span class="help-block">ROLE:</span>
													<input type="text" name="role" id="position" class="form-control" required>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" id="save" class="btn btn-primary" value="Save" name="save">
									<input type="reset" id="reset" class="btn btn-danger" value="Reset" name="Reset">

								</div>
							</form>
						</div>
					</div>
					<!-- /form horizontal -->

                <!-- Footer -->
                <?php $this->load->view('consultant/footer'); ?>
                <!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->















<script type="text/javascript">
	function findresponsible(val){
		if (val==0) {
			         $("#position").val('');
		}
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/findresponsible",
                    data:{ 'id' : val},
                      success: function(data) {
                      	console.log(data);
//                      var datas = $.parseJSON(data);
                     $("#position").val(data);
                    }
                  });
    }
</script>










<!-- Primary modal -->
					<div id="mashine" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h6 class="modal-title"><i class="icon-plus2 position-right"></i> Mashine </h6>
								</div>
								<div class="modal-body">
								<form method="post">
								       <div class="row">
									     <div class="col-md-10">
									     	<div class="form-group has-feedback">
												<input type="text" placeholder="" class="form-control" name="name" id="newmashine">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
											<span id="mashineerr" style="color:red;"></span>
									     </div>
									     <div class="col-md-2">
									       <a onclick="add_mashine();callmashine();" class="btn btn-primary">ADD</a>
									     </div>
									   </div>
									<div class="row">
									     <div class="col-md-12">
									       <table class="table">
									       	 <thead>
									       	  <tr>
									       	  	<th>VALUE</th>
									       	 	<th>ACTION</th>
									       	  </tr>
									       	  </thead>
									       	  <tbody id="mashineslist">

									       	  </tbody>
									       </table>
									     </div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								</div>
									</form>
							</div>
						</div>
					</div>
<!-- /primary modal -->
<script type="text/javascript">
	function add_mashine() {
	var newmashine = $('#newmashine').val();
	if (newmashine.length==0) {
     $('#mashineerr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_mashine",
                    data:{'name' : newmashine},
                    success: function(data) {

                    $('#mashines').html(data);
                    $('#newmashine').val('');
                    }
                  });
	}
  }

  $(document).ready(function () {

              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_mashine",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#mashines').html(data);
                    }
                  });


  });

  $(document).ready(function () {
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_mashine_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#mashineslist').html(data);
                    }
                  });
  });



  function callmashine(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_mashine_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#mashineslist').html(data);
                    }
                  });

  	          
  }
  function deletemashine(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_mashine",
                    data:{'id' :val},
                    success: function(data) {
                   

                    }
                  });
  	 callmashine();
  	 callmashine1();
  }

  function callmashine1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_mashine",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#mashines').html(data);
                    }
                  });
  }
</script>


<?php $this->load->view('consultant/manage/regulatory_requirement'); ?>
<?php $this->load->view('consultant/manage/customer_requirment'); ?>
<?php $this->load->view('consultant/manage/process_step'); ?>
<?php $this->load->view('consultant/manage/policy'); ?>
<?php $this->load->view('consultant/manage/product'); ?>
<!---->
<?php $this->load->view('consultant/manage/shift'); ?>
<?php $this->load->view('consultant/manage/trigger'); ?>

</body>
</html>
