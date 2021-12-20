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
	<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
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

	<style>
		td,th{
			text-align: center;
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
                            <span class="text-semibold">Strategic Rating Matrix</span>
                            <div class="pull-right">
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i
                                    class="icon-home2 role-left"></i>Home</a></li>

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
							<h5 class="panel-title">Strategic Rating Matrix</h5>
						</div>
						<div class="panel-body">
							<div class="row">
								<div id="rating-div" class="col-md-12">
								</div>
							</div>
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

	<div id="modal_value" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type = "hidden" class="form-control" name="type">
							<input type="text" class="form-control" name="rating_value" id="rating_value">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="edit_rating_value()">OK</button>
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<script>
	var id=0;
	var name;
	var type = 0;
	var row = 0;
	var column = 0;
	var flag = 0;
	var value_id = 0;
	var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
	$(document).ready(function(){
		viewlist();
	});
	function viewlist(){
		$.ajax({
			type: 'POST',
			url: base_url+'manage_rating_matrix_list',
			data : {
				type:'strategic'
			},
			success : function(data) {
				$("#rating-div").html(data);
			}
		});
	}
	function edit_rating_value(){
		if (row == 0 && column == 0){
			alert("You must select items.");
		}else{
			$.ajax({
				type: 'POST',
				url: base_url+'edit_manage_rating_value',
				data : {
					id:value_id,
					type:'strategic',
					like_id:row,
					conse_id:column,
					value:$('#rating_value').val()
				},
				success : function(data) {
					if (JSON.parse(data)['success'] > 0) {
						new PNotify({
							title: 'Success',
							text: 'Successfully Updated.',
							icon: 'icon-checkmark3',
							type: 'success'
						});
						// oTable.fnDeleteRow(tr);
					} else {
						new PNotify({
							title: 'Error',
							text: 'Failed.',
							icon: 'icon-blocked',
							type: 'error'
						});
					}
					$('#modal_value').modal('hide');
					viewlist();
				}
			});
		}
	}

</script>
</body>
</html>
