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
<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->

<style type="text/css">
    	.cstlist {
		    background-color:#26a69a;
		    color: #fff;
		}
    </style> 
 
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
			         	<div id="result"></div>

					<!-- Basic datatable -->
					<div class="panel panel-flat" id="ptn">
						<table class="table">
							<tbody>
						
                                
<?php 
$respo=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone->process_owner'")->row()->employee_name;
$line_worker=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone->line_worker'")->row()->employee_name;
$monitoring_type=@$this->db->query("SELECT * FROM `type_of_monitoring` WHERE `type_id`='$standalone->monitoring_type'")->row()->type_of_monitoring;
$process=@$this->db->query("SELECT * FROM `process` WHERE `id`='$standalone->process'")->row()->name;

$trigger_name=@$this->db->query("SELECT * FROM `trigger` WHERE `trigger_id`='$standalone->trigger_id'")->row()->trigger_name;
?>
	                            <tr>
									<td colspan="2" align="center"><h1>CAR ACTION NOTIFICATION</h1></td>
								</tr>
								<tr>
								    <td>Incident Identification Number</td>
									<td><?=$standalone->unique_id?></td>
								</tr>
<!--<tr>
	<td>Type of Monitoring:</td>
	<td><?/*=$monitoring_type*/?></td>
</tr>
<tr>
	<td>Process:</td>
	<td><?/*=$process*/?></td>
</tr>-->
<tr>
	<td>Line Worker:</td>
	<td>
		<?php if ($standalone->line_worker == "0"): ?>
			TBD
		<?php endif; ?>
		<?php if ($standalone->line_worker == "-1"): ?>
			N/A
		<?php endif; ?>
		<?php if ($standalone->line_worker != "0" && $standalone->line_worker != "1"): ?>
			<?=$line_worker?>
		<?php endif; ?>
	</td>
</tr>

<tr>
	<td>Process_owner:</td>
	<td><?=$respo?></td>
</tr>

								<tr>
								   <td>Trigger:</td>
									<td><?=$trigger_name?> </td>
								</tr>

								<tr>
								    <td>Customer Requirement:</td>
									<td><?=$standalone->customer_requirment?></td>
								</tr>

								<tr>
								    <td>Product:</td>
									<td><?=$standalone->product?></td>
								</tr>
								<tr>
									<td>Process Step</td>
									<td><?=$standalone->process_step?></td>
								</tr>
								<tr>
								    <td>Regulatory Requirement:</td>
									<td><?=$standalone->regulatory_requirement?></td>
								</tr>
								<tr>
								    <tr>
								    <td>Policy/Procedure/Records</td>
									<td><?=$standalone->policy?></td>
								</tr>
								</tr>
                                <tr>
								  <td>SHIFT</td>
									<td><?=$standalone->shift?></td>
								</tr>
								 <tr>
								    <td>When did the complaint occur?   </td>
									<td><?=$standalone->occur_date?></td>
								</tr>
								<tr>
								    <td>What Occurred / Nonconformity?</td>
									<td><?=$standalone->prob_desc?></td>
								</tr>

								<tr>
								    <td>Correction: </td>
									<td><?=$standalone->correction?></td>
								</tr>
								<tr>
								    <td>Grade of Non-conformity:</td>
									<td><?=$standalone->business_impact?></td>
								</tr>


<tr>
	<td>Root cause:
		<a href="<?php echo base_url();?>uploads/Doc/<?=$standalone->root_doc?>"><?=$standalone->root_doc?>
		</a>
	</td>
	<td>
		<?=$standalone->root_cause?>
	</td>
</tr>

<tr>
	<td>CORRECTIVE ACTION PLAN:
		<a href="<?php echo base_url();?>uploads/Doc/<?=$standalone->corrective_plan_doc?>"><?=$standalone->corrective_plan_doc?>
		</a>
	</td>
	<td>
		<?=$standalone->action_plan?>
	</td>
</tr>

<tr>
	<td>CORRECTIVE ACTION:
		<a href="<?php echo base_url();?>uploads/Doc/<?=$standalone->corrective_doc?>"><?=$standalone->corrective_doc?>
		</a>
	</td>
	<td>
		<?=$standalone->corrective_action?>
	</td>
</tr>
<tr>
	<td>Verification of Effectiveness:
		<a href="<?php echo base_url();?>uploads/Doc/<?=$standalone->verification_doc?>"><?=$standalone->verification_doc?>
		</a>
	</td>
	<td>
		<?=$standalone->verification_effectiveness?>
	</td>
</tr>



								<tr>
								    <td>By When: </td>
									<td><?=$standalone->by_when_date?></td>
								</tr>
							</tbody>
						</table>
					</div>

					<a href="<?php echo base_url(); ?>index.php/consultant/resolution_list" class="btn btn-primary pull-right">Continue</a>
					<!-- /basic datatable -->

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
    function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;

		 document.body.innerHTML = printContents;

		 window.print();

		 document.body.innerHTML = originalContents;
	}
	function mails(val){
		$("#mails").prop("href","mailto:"+val);
	}
</script>

<script type="text/javascript">
	
console.clear();


</script>

<script type="text/javascript">
	
	function sendmail(val){

		$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/Company/car_action",
                    data:{'id' : val},
                    success: function(data) {

                    var	res='<div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button><span class="text-semibold"></span>Mail Successfully Send..</div>';
                    $('#result').html(res);
                    }
                  });

	}
</script>
</body>

</html>
