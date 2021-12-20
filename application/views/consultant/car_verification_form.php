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
						<h4><?=$title?></h4>
						<div class="text-right" style="margin-top: 20px;">
							<a title="Download"  class="btn btn-primary "  onclick="printDiv('ptn')" >Print</a>
							<a href="<?php echo base_url(); ?>index.php/consultant/resolution_list" class="btn btn-success">Continue</a>
						</div>
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

						<div class="panel-body" id="ptn">
							<form id="target"  method="post" action="">

								<?php
								$respo=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone_data->process_owner'")->row()->employee_name;
								$line_worker=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone_data->line_worker'")->row()->employee_name;
								$monitoring_type=@$this->db->query("SELECT * FROM `type_of_monitoring` WHERE `type_id`='$standalone_data->monitoring_type'")->row()->type_of_monitoring;

								$process=@$this->db->query("SELECT * FROM `process` WHERE `id`='$standalone_data->process'")->row()->name;
								$trigger_name=@$this->db->query("SELECT * FROM `trigger` WHERE `trigger_id`='$standalone_data->trigger_id'")->row()->trigger_name;
								$employee_email=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone_data->line_worker'")->row()->employee_email;
								?>

								<table class="table table-lg table-bordered">
									<tr>
										<td colspan="3" align="center">Corrective Actions Resolution Verification Form</td>
									</tr>

									<tr>
										<td>
											<span class="help-block">Current Date:</span>
										</td>
										<td align="center">
											<input type="text" class="form-control" value="<?=date('Y-m-d')?>"  >
										</td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Corrective Actions ID#:</span>
										</td>
										<td align="center">
											<input type="text" class="form-control"  value="<?php echo $standalone_data->unique_id; ?>"  >
										</td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Date of Occurance:</span>
										</td>
										<td align="center">
											<input type="date" class="form-control" value="<?=date('Y-m-d')?>" >
										</td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Description of NonConformity:</span>
										</td>
										<td align="center">
											<textarea class="form-control" ><?php echo $standalone_data->prob_desc;?></textarea>
										</td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block"></span>
										</td>
										<td align="center"> </td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Action Taken:</span>
										</td>
										<td align="center">
											<input type="text" class="form-control" value="<?php echo $standalone_data->action_taken;?>">
										</td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block"></span>
										</td>
										<td align="center"></td>
										<td></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Name of Employee Involved:</span>
										</td>
										<td align="center"><input type="text" name=""></td>
										<td>Signature <input type="text" name=""></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Name of Employee Involved:</span>
										</td>
										<td align="center"><input type="text" name=""></td>
										<td>Signature <input type="text" name=""></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Name of Employee Involved:</span>
										</td>
										<td align="center"><input type="text" name=""></td>
										<td>Signature <input type="text" name=""></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Name of Employee Involved:</span>
										</td>
										<td align="center"><input type="text" name=""></td>
										<td>Signature <input type="text" name=""></td>
									</tr>
									<tr>
										<td>
											<span class="help-block">Name of Employee Involved:</span>
										</td>
										<td align="center"><input type="text" name=""></td>
										<td>Signature <input type="text" name=""></td>
									</tr>


									<tr>
										<td>
											<span class="help-block">Supervisor:</span>
										</td>
										<td align="center"><span class="help-block">Managing Director</span></td>
										<td>Signature <input type="text" name=""></td>
									</tr>

								</table>
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
                      var datas = $.parseJSON(data)
                     $("#position").val(datas.position_name);
                    }
                  });
    }
</script>


<script>
    shortcut.add("ctrl+s", function() {

        $("#save").click()
    });   
    shortcut.add("ctrl+r", function() {

        $("#reset").click()
    }); 
</script>



<script type="text/javascript">
	
$('body').on('click','.savedata',function(e){

   var dialog = bootbox.dialog({
   title: 'Verification Form Question',
   message: "<p>If your action involves a nonconformity related to a record management issue or the need for additional training a verification form is needed to verify the training or discussion between the supervisor and involved parties. This document must be completed and signed by all involved  before the action can be closed</p> <h5>Does your action require this form ?</h5>",
   size: 'small',
   buttons: {
       cancel: {
           label: "NO",
           className: 'btn-danger',
           callback: function(){
               dialog.modal('hide');
               
           }
       },
      
           ok: {
             label: "YES",
             className: 'btn-info',
             callback: function(){
           		$( "#target" ).submit();
          	}
           }
    }

  
   });

});

</script>




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
