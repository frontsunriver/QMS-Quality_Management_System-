<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
<!--	<link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
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

	<!-- <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
 -->	<script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>assets/js/core/app.js"></script>
	<!-- <script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/datatables_basic.js"></script> -->
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script> 

<style type="text/css">
    	.smlist {
		    background-color:#26a69a;
		    color: #fff;
		}
    </style> 
 
</head>

<body class="navbar-top">
	<!-- Main navbar -->
	<?php $this->load->view('admin/main_header.php'); ?>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php $this->load->view('admin/sidebar'); ?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-lan2 position-left"></i> <span class="text-semibold"><?=$title?></span>
                             <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modal_theme_primary">New Plan</button>
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
                     <?php
                      
                      if($this->session->flashdata('message')=='success') { ?>
                      	 <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Thank you!</span>Plan Successfully created.. 
				        </div>
                    <?php   } ?>
                     
                        <?php if($this->session->flashdata('message')=='failed') { ?>
                      	 <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Oppps!</span>Something Went Wrong Please try again.
				        </div>
                      <?php   } ?>
                      <?php if($this->session->flashdata('message')=='success_del') { ?>
                      	  <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							Plan Successfully Deleted.. 
				        </div>
                      <?php   } ?>

                      <?php if($this->session->flashdata('message')=='update_success') { ?>
                      	  <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							Plan Successfully Updated.. 
				        </div>
                      <?php   } ?>
					<!-- Basic datatable -->
					<div class="panel panel-flat" style="overflow:auto;">
						<table class="table datatable-basic">
							<thead>
								<tr>
								    <th>No</th>
									<th>Plan Name</th>
									<th>User Limitation</th>
									<th>Total Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $count=1;
                                 foreach ($plans as $plan) { ?>
								<tr>
								    <td><?=$count?></td>
									<td><?=$plan->plan_name?></td>
									<td><?=$plan->no_of_user?></td>
									<td>$ <?=$plan->total_amount?> </td>
									<td>
									<ul class="icons-list">
										<li class="text-primary-600" onclick="edit(<?=$plan->plan_id?>);"><a href="#"><i class="icon-pencil7"></i></a></li>

										<?php if($plan->is_trial != '1'){ ?>
											<li class="text-danger-600"><a href="#" id="<?=$plan->plan_id?>" class="delete" ><i class="icon-trash"></i></a></li>
										<?php } ?>

									</ul>
									</td>
								</tr>
								  <?php $count++; } ?>
							</tbody>
						</table>
					</div>
					<!-- /basic datatable -->

					<!-- Footer -->
					<?php $this->load->view('admin/footer'); ?>
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
									<h6 class="modal-title"><i class="icon-lan2 position-right"></i> Edit  Plan</h6>
								</div>
								<div class="modal-body">
								<form action="<?php echo base_url();?>index.php/admin/edit_plan"  method="post">
								       <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Plan Name: </label>
												<input type="text" placeholder="Ex : 15 Accounts/Year" class="form-control" name="plan_name" id="plan_name">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									     </div>

									    <div class="row" >
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>User Limitation: </label>
												<input type="number" placeholder="Ex : 10"  class="form-control" value="1" name="no_of_user" id="no_of_user">
												<div class="form-control-feedback">
													<i class="icon-user text-muted"></i>
												</div>
											</div>
									     </div>
									     </div>

									

									      <div class="row" >
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Total Amount(Full Plan): </label>
												<input type="number" placeholder="Ex : 100" class="form-control" name="total_amount" id="total_amount">
												<input type="hidden"  class="form-control" name="plan_id1" id="plan_id1">
												<div class="form-control-feedback">
													<i class="icon-coin-dollar text-muted"></i>
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
               window.location.href="<?php echo base_url();?>index.php/admin/delete_plan/"+id;
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
                    url: "<?php echo base_url(); ?>index.php/admin/findplan",
                    data:{ 'id' : val},
                      success: function(data) {
                      var datas = $.parseJSON(data)
                     $("#plan_name").val(datas.plan_name);
                     $("#no_of_user").val(datas.no_of_user);
                     $("#total_amount").val(datas.total_amount);
                     $("#plan_id1").val(datas.plan_id);

                     if(datas.is_trial == '1'){
						 $("#plan_name").attr('disabled','1');
						 $("#total_amount").attr('disabled','1');
					 }
					 else{
						 $("#plan_name").removeAttr('disabled');
						 $("#total_amount").removeAttr('disabled');
					 }
                    }
                  });
    }
</script>
<?php $this->load->view('common/update-password-popup'); ?>
	<!-- /page container -->
</body>


<!-- Primary modal -->
					<div id="modal_theme_primary" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h6 class="modal-title"> New Plan</h6>
								</div>
								<div class="modal-body">
								<form action="<?php echo base_url();?>index.php/admin/add_plan"  method="post">
								       <div class="row">
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Plan Name: </label>
												<input type="text" placeholder="Ex : 15 Accounts/Year" class="form-control" name="plan_name">
												<div class="form-control-feedback">
													<i class="icon-list text-muted"></i>
												</div>
											</div>
									     </div>
									     </div>

									    <div class="row" >
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>User Limitation: </label>
												<input type="number" placeholder="Ex : 10" class="form-control" value="1" name="no_of_user">
												<div class="form-control-feedback">
													<i class="icon-user text-muted"></i>
												</div>
											</div>
									     </div>
									     </div>

							

									      <div class="row" >
									     <div class="col-md-12">
									     	<div class="form-group has-feedback">
												<label>Total Amount(Full Plan): </label>
												<input type="number" placeholder="Ex : 100" class="form-control" name="total_amount">
												<div class="form-control-feedback">
													<i class="icon-coin-dollar text-muted"></i>
												</div>
											</div>
									     </div>
									     </div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary"><i class="icon-plus2 position-right"></i> Add</button>
								</div>
									</form>
							</div>
						</div>
					</div>
<!-- /primary modal -->

</html>
