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
	                            }else{
                                    $audito = $audito1->logo;
	                            }
							}
							?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?= $audito ?>" style="height:50px;">
								 <span class="text-semibold"><?=$title?></span>
                             <div class="pull-right">
								 <a title="Download" type="button" class="btn btn-primary btn-sm "  onclick="printDiv('ptn')" ><i class="icon-download " aria-hidden="true"></i></a>
                            <a title="Mail" href="mailto:mike.lee@csiclosures.com" class="btn btn-primary"><i class="icon-envelope "  aria-hidden="true"></i></a>
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
									<td colspan="2" align="center"><h1>FORM DETAILS</h1></td>
								</tr>
								<tr>
								    <td>Incident Identification Number</td>
									<td><?=$standalone->unique_id?></td>
								</tr>
							<tr>
								<td>Type of Audit:</td>
								<td><?=$monitoring_type?></td>
							</tr>
							<tr>
								<td>Process:</td>
								<td><?=$process?></td>
							</tr>
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
								    <td>Customer Requirement:</td>
									<td><?=$standalone->customer_requirment?></td>
								</tr>

								<tr>
								    <td>Product:</td>
									<td><?=$standalone->product?></td>
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
	<td>Root cause:</td>
	<td><?=$standalone->root_cause?></td>
</tr>
<?php if($standalone->root_doc != '') { ?>
	<tr>
		<td>Root cause Document:</td>
		<td><a onclick="javascript:window.history.back()"><i class="icon-download " aria-hidden="true"></i>  <?=$standalone->root_doc?></a></td>
	</tr>
<?php } ?>

<tr>
	<td>Corrective Action Plan </td>
	<td><?=$standalone->action_plan?></td>
</tr>

<?php if($standalone->corrective_plan_doc != '') { ?>
	<tr>
		<td>Corrective Action Plan Document:</td>
		<td><a href="<?php echo base_url(); ?>uploads/Doc/<?=$standalone->corrective_plan_doc?>"><i class="icon-download " aria-hidden="true"></i>  <?=$standalone->corrective_plan_doc?></a></td>
	</tr>
<?php } ?>

<tr>
	<td>Corrective Action </td>
	<td><?=$standalone->corrective_action?></td>
</tr>

<?php if($standalone->corrective_doc != '') { ?>

	<tr>
		<td>Corrective Action Document:</td>
		<td><a href="<?php echo base_url(); ?>uploads/Doc/<?=$standalone->corrective_doc?>"><i class="icon-download " aria-hidden="true"></i>  <?=$standalone->corrective_doc?></a></td>
	</tr>
<?php } ?>


<tr>
	<td>Verification of Effectiveness</td>
	<td><?=$standalone->verification_effectiveness?></td>
</tr>

<?php if($standalone->verification_doc != '') { ?>

	<tr>
		<td>Verification of Effectiveness Document:</td>
		<td><a href="<?php echo base_url(); ?>uploads/Doc/<?=$standalone->verification_doc?>"><i class="icon-download " aria-hidden="true"></i>  <?=$standalone->verification_doc?></a></td>
	</tr>

<?php } ?>



								<tr>
								    <td>By When: </td>
									<td><?=$standalone->by_when_date?></td>
								</tr>
							</tbody>
						</table>
					</div>

					<a onclick="javascript:window.history.back()" class="btn btn-primary pull-right">Back</a>
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
</script>

<script type="text/javascript">
	
console.clear();


</script>
</body>

</html>
