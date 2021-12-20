<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/datatables_basic.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script> 

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
							<h4>
<?php
							if ($this->session->userdata('consultant_id')) {
								$consultant_id= $this->session->userdata('consultant_id');
	                            $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

	                            $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

	                            if ($logo1->logo=='1') {
	                            	$logo=$dlogo;
	                            }else{
	                            	 $logo=$logo1->logo;
	                            }
							}
							?>
								<img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;">

							 <span class="text-semibold"><?=$title?></span>
							<div class="pull-right">
							        <select class="form-conrtol" onchange="mails(this.value);">
							        
                                       <option><?=$admin_emails?></option>
                                  
                                    <option><?=$comp_email?></option>
                                    <?php 
                                    foreach ($employees_email as $employees_emails) {?>
                                       <option><?=$employees_emails->employee_email?></option>
                                    <?php }?>

							      		
							      	</select>


								 <a title="Download" type="button" class="btn btn-primary btn-sm "  onclick="printDiv('ptn')" ><i class="icon-download " aria-hidden="true"></i></a>
                            <a title="Mail" id="mails" href="mailto:<?=$admin_emails?>" class="btn btn-primary"><i class="icon-envelope "  aria-hidden="true"></i></a>
							</div>
                           

							</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i class="icon-home2 position-left"></i>Home</a></li>
							<li><a href="#"><?=$title?></a></li>
						
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
                
					<!-- Basic datatable -->
					<div class="panel panel-flat" id="ptn">
						<table class="table  table-bordered">
							<thead>
							<tr>
								<td colspan="9" align="center"><h4><b>MONITORING ACTIVITY</b></h4></td>
							</tr>
								<tr>
								    <th>No</th>
								    <th>Name</th>
								    <th>Frequency</th>
                                    <th>Process Owner</th>
									<th>Responsible Party</th>
									<th>Review Date</th>
									<th style="width:16%;">Status </th>
								</tr>
							</thead>
							<tbody>
								<?php $count=1;
                                 foreach ($standalone_data as $standalone) { ?>
                             <?php
                             $respo=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone->responsible_party'")->row()->employee_name;
                             $process_owner=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$standalone->sme'")->row()->employee_name;
                             ?>
	
								<tr>
								    <td><?=$count?></td>
								    <td><?=$standalone->name?></td>
									<td><?=$standalone->frequency_name?></td>
                                    <td><?=$process_owner?></td>
                                    <td><?=$respo?></td>
                                     <td><?=$standalone->review_date?></td>
									<td>
										<?php
										if ($standalone->type == 0){
											if ($standalone->due + $standalone->days > 0){
												echo "<span class='label bg-success'>Due In ".($standalone->due+$standalone->days)." days</span>";
											}else if ($standalone->due + $standalone->days < 0){
												echo "<span class='label bg-danger'>Past Due ".abs($standalone->due+$standalone->days)." days</span>";
											}else{
												echo "<span class='label bg-success'>Success</span>";
											}
										}else if ($standalone->type == 1){
											if (((strtotime($standalone->review_date) - strtotime($standalone->now_date))/3600)+$standalone->days > 0){
												echo "<span class='label bg-success'>Due In ".ceil(((strtotime($standalone->review_date) - strtotime($standalone->now_date))/3600)+$standalone->days)." hours</span>";
											}else if (((strtotime($standalone->review_date) - strtotime($standalone->now_date))/3600)+$standalone->days < 0){
												echo "<span class='label bg-danger'>Past Due ".abs(ceil(((strtotime($standalone->review_date) - strtotime($standalone->now_date))/3600)+$standalone->days))." hours</span>";
											}
										}else{
											if (((strtotime($standalone->review_date) - strtotime($standalone->now_date))/60)+$standalone->days > 0){
												echo "<span class='label bg-success'>Due In ".ceil(((strtotime($standalone->review_date) - strtotime($standalone->now_date))/60)+$standalone->days)." minutes</span>";
											}else if (((strtotime($standalone->review_date) - strtotime($standalone->now_date))/60)+$standalone->days < 0){
												echo "<span class='label bg-danger'>Past Due ".abs(ceil(((strtotime($standalone->review_date) - strtotime($standalone->now_date))/60)+$standalone->days))." minutes</span>";
											}
										}
										?>
									</td>
								</tr>
								  <?php $count++; } ?>
							</tbody>
						</table>
					</div>
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
<!-- Primary modal -->
					<div id="modal_theme_primary1" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h6 class="modal-title"><i class="icon-lan2 position-right"></i> Edit Customer</h6>
								</div>
								<div class="modal-body">
								<form action="<?php echo base_url();?>index.php/Employee/edit_cust"  method="post">
								       <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Customer Name: </label>
												<input type="text" placeholder="" class="form-control" name="name" id="name">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									    </div>
									    <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>City: </label>
												<input type="text" placeholder="" class="form-control" name="city" id="city">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									    </div>
									    <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>State: </label>
												<input type="text" placeholder="" class="form-control" name="state" id="state">
												<input type="hidden" name="cust_id" id="cust_id">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									    </div>
									    <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Address: </label>
												<textarea name="address" class="form-control" id="address"></textarea>
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									    </div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary"><i class="icon-plus2 position-right"></i> Edit</button>
								</div>
									</form>
							</div>
						</div>
					</div>
<!-- /primary modal -->

<script type="text/javascript">
	function mails(val){
   
   $("#mails").prop("href","mailto:"+val);


	}
</script>

<script type="text/javascript">
  $('body').on('click','.delete' ,function(e){
     var id = $(this).attr('id');
    var dialog = bootbox.dialog({
    title: 'Confirmation',
    message: "<h4>Are You Sure ?</h4>",
    size: 'small',
    buttons: {
        cancel: {
            label: "Cancel",
            className: 'btn-danger',
            callback: function(){
                dialog.modal('hide');
            }
        },
       
        ok: {
            label: "OK",
            className: 'btn-success',
            callback: function(){
               window.location.href="<?php echo base_url();?>index.php/consultant/delete_standaloneform/"+id;
            }
        }
     }
    });
});
</script>

<script type="text/javascript">
	function edit(val){
		 $('#modal_theme_primary1').modal('show'); 
               $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/findcust",
                    data:{ 'id' : val},
                      success: function(data) {
                      var datas = $.parseJSON(data)
                     $("#name").val(datas.name);
                     $("#address").val(datas.address);
                     $("#city").val(datas.city);
                     $("#state").val(datas.state);
                     $("#cust_id").val(datas.id);
                    }
                  });
    }
</script>
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
