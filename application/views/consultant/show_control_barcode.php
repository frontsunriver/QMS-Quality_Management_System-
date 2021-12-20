<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control</title>
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
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/col_reorder.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
    <!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->
    <style type="text/css">
        td, th {text-align: center; word-break:keep-all!important;}
        .form-group{
            margin-bottom: 10px !important;
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
                            <img src="<?php echo base_url(); ?>uploads/logo/<?=$audito?>" style="height:50px;">
                            <span class="text-semibold">Control</span>

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

            <?php  $img_src = base_url() . "uploads/file/";  ?>
            <!-- Content area -->
            <div class="content" style="">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <form id="submit_form" class="form-horizontal" action="<?php echo base_url(); ?>index.php/Consultant/add_barcode" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="control_id" value="<?=$control_id?>" />
                            <input type="hidden" name="material_id" id="material_id"/>
                            <input type="hidden" name="machine_id" id="machine_id"/>
                            <input type="hidden" name="supplier_id" id="supplier_id"/>
                            <input type="hidden" name="customer_id" id="customer_id"/>
                            <input type="hidden" name="record_id" id="record_id"/>
                            <input type="hidden" name="procedure_id" id="procedure_id"/>
                            <input type="hidden" name="sign_info" id="sign_info"/>
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label style="padding-left: 3px;">Process Step</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form-control" disabled value = "<?=$process_step?>">
                                        </div>
                                        <div class="col-sm-2"><label style="padding-left: 3px;">Controls</label></div>
                                        <div class="col-sm-4"><input class="form-control" disabled value = "<?=$control_name?>"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-4"><label style="padding-left: 3px;">Product</label></div>
                                        <div class="col-sm-8">
                                            <!--<input class="form-control" placeholder="Product Name" name = "product_name">-->
                                            <select class="form-control" name="product_name">
                                                <?php foreach($product_list as $product): ?>
                                                    <option <?php if($product->name == $control_data->product_name) echo "selected";?> value="<?=$product->name?>"><?=$product->name?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input type="text" class="form-control" placeholder="Bar code Information" name = "product_barcode"
                                                   value="<?=$control_data->product_barcode?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input class="form-control" placeholder="Quantity" name = "product_quantity"
                                                   value="<?=$control_data->product_quantity?>" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12">
									<?php if ($control_data->material_active == 1) : ?>
										<div class="form-group">

												<div class="col-sm-2"><label style="padding-left: 3px;">Material</label></div>
												<div class="col-sm-10">
													<table class="table datatable-material">
													</table>
												</div>
										</div>
									<?php endif; ?>

									<?php if ($control_data->supplier_active == 1) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="control-label">Supplier</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <table class="table datatable-supplier">
                                            </table>
                                        </div>
                                    </div>
									<?php endif; ?>

									<?php if ($control_data->customer_active == 1) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="control-label">Customer</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <table class="table datatable-customer">
                                            </table>
                                        </div>
                                    </div>

									<?php endif; ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12">

									<?php if ($control_data->record_active == 1) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2"><label style="padding-left: 3px;">Records</label></div>
                                        <div class="col-sm-10">
                                            <table class="table datatable-record">
                                            </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8" id="record_file_div">

                                        </div>
                                    </div>
									<?php endif; ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12">
									<?php if ($control_data->machine_active == 1) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2"><label style="padding-left: 3px;">Machine and Buildings</label></div>
                                        <div class="col-sm-10">
                                            <table class="table datatable-machine">
                                            </table>
                                        </div>
                                    </div>
									<?php endif; ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12">
									<?php if ($control_data->procedure_active == 1) : ?>
                                    <div class="form-group">
                                        <div class="col-sm-2"><label style="padding-left: 3px;">Procedures</label></div>
                                        <div class="col-sm-10">
                                            <table class="table datatable-procedure">
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8" id="procedure_file_div">

                                        </div>
                                    </div>
									<?php endif; ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="col-sm-6">
                                        <label style="padding-left: 3px;">REQUIREMENT MET (YES/NO)</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-6">
                                            <div class="col-sm-6"><input type="radio" style="height: 20px;" name="requirement_met" value="0" <?php if (isset($control_data)  && $requirement_met == 0): ?><?php echo "checked";?><?php endif;?>></div>
                                            <div class="col-sm-6"><label>yes</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6"><input type="radio" style="height: 20px;" name="requirement_met" value="1" <?php if (isset($control_data)  && $requirement_met == 1): ?><?php echo "checked";?><?php endif;?>></div>
                                            <div class="col-sm-6"><label>no</label></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-sm-2" style="padding:0px;">
                                            <label style="padding-left: 3px;">Sign Image</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <img src = "<?=base_url(); ?>uploads/sign/<?=$control_data->sign_image?>" width="auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-2">Reason</div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="reason" rows="4" readonly><?=$reason?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-offset-6 col-sm-6">
                                    <div class="pull-right">
                                        <a onclick="window.history.back()" class="btn btn-primary">Back</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
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
<div id="modal_material" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Material Info</h5>
            </div>
            <form id="material_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Name</label>
                                <input type="text" placeholder="" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>UPC Number</label>
                                <input type="text" placeholder="" name="upc" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label>Amount</label>
                                <input type="text" placeholder="" name="size" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Barcode Information</label>
                                <input type="text" placeholder="" name="barcode_info" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_supplier" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Supplier Info</h5>
            </div>
            <form id="supplier_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Material</label>
                                <input type="text" placeholder="" name="material" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Name</label>
                                <input type="text" placeholder="" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Phone</label>
                                <input type="text" placeholder="+99-99-9999-9999" name="phone" data-mask="+99-99-9999-9999" class="form-control">
                                <span class="help-block">+99-99-9999-9999</span>
                            </div>
                            <div class="col-sm-6">
                                <label>Email Address</label>
                                <input type="text" placeholder="eugene@kopyov.com" name="email" class="form-control">
                                <span class="help-block">name@domain.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Street Address</label>
                                <input type="text" name="street_address" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_customer" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Customer Info</h5>
            </div>
            <form id="customer_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Customer</label>
                                <input type="text" placeholder="" name="customer" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Name</label>
                                <input type="text" placeholder="" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Phone</label>
                                <input type="text" placeholder="+99-99-9999-9999" name="phone" data-mask="+99-99-9999-9999" class="form-control">
                                <span class="help-block">+99-99-9999-9999</span>
                            </div>
                            <div class="col-sm-6">
                                <label>Email Address</label>
                                <input type="text" placeholder="eugene@kopyov.com" name="email" class="form-control">
                                <span class="help-block">name@domain.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Product</label>
                                <input type="text" name="product" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Street Address</label>
                                <input type="text" name="street_address" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_record" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Record Info</h5>
            </div>
            <form id="record_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Name</label>
                                <input type="text" placeholder="" name="name" class="form-control" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Description</label>
                                <textarea name="description" placeholder="description" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Active Date</label>
                                <input type="date" name="version_date" class="form-control" value="<?=date('Y-m-d')?>" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Review Date</label>
                                <input type="date" name="revision_date" class="form-control" value="<?=date('Y-m-d')?>" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>File</label>
                                <input class="form-control" id="file_name" name="file_name" type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_machine" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Machine Info</h5>
            </div>
            <form id="machine_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Name</label>
                                <input type="text" placeholder="" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Number</label>
                                <input type="text" placeholder="" name="number" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Location</label>
                                <input type="text" placeholder="" name="location" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Last Maintenance</label>
                                <input type="text" placeholder="" name="last_maintenance" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Next Maintenance</label>
                                <input type="text" placeholder="" name="next_maintenance" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_procedure" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Procedure Info</h5>
            </div>
            <form id="procedure_form">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Procedures Title</label>
                                <input type="text" placeholder="" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Description</label>
                                <textarea name="description" placeholder="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Active Date</label>
                                <input type="date" name="version_date" class="form-control" value="<?=date('Y-m-d')?>" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Review Date</label>
                                <input type="date" name="revision_date" class="form-control" value="<?=date('Y-m-d')?>" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>File</label>
                                <input class="form-control" id="file_name" name="file_name" type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_sign" class="modal fade">
    <div class="modal-dialog">
        <center>
            <fieldset style="width: 500px;">
                <br/>
                <br/>
                <H1 style="color: white;">You have to sign your name.</H1>
                <div id="signaturePad" style="background-color:white; border: 1px solid #ccc; height: 250px; width: 500px;">
                </div>
                <br/>
                <button id="saveSig" type="button" class="btn bg-primary"><i class="icon-floppy-disk position-left"></i> Save Signature</button>&nbsp;
                <button id="clearSig" type="button" class="btn bg-primary"><i class="icon-trash position-left"></i> Clear Signature</button>&nbsp;
                <button id="saveSig" type="button" class="btn bg-primary" data-dismiss="modal"><i class="icon-cancel-square2 position-left"></i> Cancel</button>
                <div id="imgData"></div>
                <div id="imgData"></div>
                <br/>
                <br/>
            </fieldset>
        </center>
    </div>
</div>
<div id="modal_value" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">URL</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="url">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /page container -->
<script>
    var control_id = "<?=$control_id?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    var material_list = "<?=$control_data->traceability_name?>";
    if (material_list == ""){
        material_list = "0";
    }
    var supplier_list = "<?=$control_data->supplier?>";
    if (supplier_list == ""){
        supplier_list = "0";
    }
    var customer_list = "<?=$control_data->customer?>";
    if (customer_list == ""){
        customer_list = "0";
    }
    var procedure_list = "<?=$control_data->procedures_name?>";
    if (procedure_list == ""){
        procedure_list = "0";
    }
    var record_list = "<?=$control_data->records_name?>";
    if (record_list == ""){
        record_list = "0";
    }
    var machine_list = "<?=$control_data->machine_work?>";
    if (machine_list == ""){
        machine_list = "0";
    }
    var record_file_array = "<?=$control_data->records_file_path?>";
    var procedure_file_array = "<?=$control_data->procedures_file_path?>";
    var record_html = "";
    for(i=0;i<record_file_array.length;i++){
        record_html = record_html + '<a href="<?php echo base_url(); ?>uploads/Doc/'+record_file_array[i]+'" target="download"><i class="icon-download " aria-hidden="true"></i>'+record_file_array[i]+'&nbsp;&nbsp;</a>';
    }
    $("#record_file_div").html(record_html);
    var procedure_html = "";
    for(i=0;i<procedure_file_array.length;i++){
        procedure_html = procedure_html + '<a href="<?php echo base_url(); ?>uploads/Doc/'+procedure_file_array[i]+'" target="download"><i class="icon-download " aria-hidden="true"></i>'+procedure_file_array[i]+'&nbsp;&nbsp;</a>';
    }
    $("#procedure_file_div").html(procedure_html);

    function submit_form(){
        var form = document.getElementById("submit_form");
        var check_material = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_material'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_material = form[i].value;
                        }else{
                            check_material = check_material+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#material_id").val(check_material);
        var check_machine = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_machine'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_machine = form[i].value;
                        }else{
                            check_machine = check_machine+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#machine_id").val(check_machine);
        var check_supplier = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_supplier'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_supplier = form[i].value;
                        }else{
                            check_supplier = check_supplier+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#supplier_id").val(check_supplier);
        var check_customer = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_customer'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_customer = form[i].value;
                        }else{
                            check_customer = check_customer+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#customer_id").val(check_customer);
        var check_record = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_record'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_record = form[i].value;
                        }else{
                            check_record = check_record+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#record_id").val(check_record);
        var check_procedure = "";
        var temp = 0;
        for (i=0; i<form.length; i++) {
            if (form[i].name != '') {
                if (form[i].name == 'check_procedure'){
                    if (form[i].checked == true){
                        if (temp == 0){
                            check_procedure = form[i].value;
                        }else{
                            check_procedure = check_procedure+","+form[i].value;
                        }
                        temp++;
                    }
                }
            }
        }
        $("#procedure_id").val(check_procedure);
        $("#modal_sign").modal();
    }
    function scan(type){
        $('#url').val("<?php echo  $_SERVER["HTTP_HOST"]."".base_url(); ?>index.php/welcome/"+type+"_barcode/<?=$control_id?>");
        $('#modal_value').modal();
    }
    function get_image(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/consultant/get_barcode_image",
            data:{ 'id' : control_id},
            success: function(data) {
                data = JSON.parse(data);
                $("#product_barcode_image").attr("src","<?php echo base_url(); ?>uploads/file/"+data.product_barcode_image);
//                $("#traceability_barcode_image").attr("src","<?php //echo base_url(); ?>//uploads/file/"+data.traceability_barcode_image);
//                $("#records_barcode_image").attr("src","<?php //echo base_url(); ?>//uploads/file/"+data.records_barcode_image);
//                $("#machine_barcode_image").attr("src","<?php //echo base_url(); ?>//uploads/file/"+data.machine_barcode_image);
//                $("#procedures_barcode_image").attr("src","<?php //echo base_url(); ?>//uploads/file/"+data.procedures_barcode_image);
            }
        });
    }

    $(function(){
        $('select[name="product_name"]').on('change', function(){
            alert('123');
        })
    });
    $(document).ready(function () {
        /** Set Canvas Size **/
        var canvasWidth = 498;
        var canvasHeight = 248;

        /** IE SUPPORT **/
        var canvasDiv = document.getElementById('signaturePad');
        canvas = document.createElement('canvas');
        canvas.setAttribute('width', canvasWidth);
        canvas.setAttribute('height', canvasHeight);
        canvas.setAttribute('id', 'canvas');
        canvasDiv.appendChild(canvas);
        if (typeof G_vmlCanvasManager != 'undefined') {
            canvas = G_vmlCanvasManager.initElement(canvas);
        }
        context = canvas.getContext("2d");

        var clickX = new Array();
        var clickY = new Array();
        var clickDrag = new Array();
        var paint;

        /** Redraw the Canvas **/
        function redraw() {
            canvas.width = canvas.width; // Clears the canvas

            context.strokeStyle = "#000000";

            context.lineWidth = 2;

            for (var i = 0; i < clickX.length; i++) {
                context.beginPath();
                if (clickDrag[i] && i) {
                    context.moveTo(clickX[i - 1], clickY[i - 1]);
                } else {
                    context.moveTo(clickX[i] - 1, clickY[i]);
                }
                context.lineTo(clickX[i], clickY[i]);
                context.closePath();
                context.stroke();
            }
        }

        /** Save Canvas **/
        $("#saveSig").click(function saveSig() {
            var dialog = bootbox.dialog({
                message: "<h4>Are You Sure to Save Your Signature ?</h4>",
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
                            var sigData = canvas.toDataURL("image/png");
                            var nicURI = base_url+"save_signature_control_barcode";
                            var A = new FormData();
                            A.append("id", control_id);
                            A.append("sign", sigData);
                            var C = new XMLHttpRequest();
                            C.open("POST", nicURI);
                            C.onload = function() {
                                var E;
                                E = C.responseText;
                                if (E.indexOf("fail") >= 0) {
                                    $("#imgData").html('Sorry! Your signature was not saved');
                                    return;
                                }else{
                                    $("#modal_sign").modal("hide");
                                    $("#sign_info").val(E);
                                    $("#submit_form").submit();
                                }
                            };
                            C.send(A);
                        }
                    }
                }
            });
        });

        $('#clearSig').click(
            function clearSig() {
                clickX = new Array();
                clickY = new Array();
                clickDrag = new Array();
                context.clearRect(0, 0, canvas.width, canvas.height);
            });

        /**Draw when moving over Canvas **/
        $('#signaturePad').mousemove(function (e) {
            this.style.cursor = 'pointer';
            if (paint) {
                var left = $(this).offset().left;
                var top = $(this).offset().top;

                addClick(e.pageX - left, e.pageY - top, true);
                redraw();
            }
        });

        /**Stop Drawing on Mouseup **/
        $('body').mouseup(function (e) {
            paint = false;
        });

        /** Starting a Click **/
        function addClick(x, y, dragging) {
            clickX.push(x);
            clickY.push(y);

            clickDrag.push(dragging);
        }

        $('#signaturePad').mousedown(function (e) {
            paint = true;

            var left = $(this).offset().left;
            var top = $(this).offset().top;

            addClick(e.pageX - left, e.pageY - top, false);
            redraw();
        });
    });
    $(function() {
        // Table setup
        // ------------------------------

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable;
        // Generate content for a column
        var table = $('.datatable-material').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 30,
                    mRender: function (data, type, row, pos) {
                        var info = table.page.info();
                        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                    }
                },
                { "sTitle" : "Name", "mData": "name", "sWidth": 300 },
                { "sTitle" : "UPC Number", "mData": "upc", "sWidth": 100 },
                { "sTitle" : "Amount", "mData": "size", "sWidth": 100 },
                { "sTitle" : "Barcode", "mData": "barcode_info", "sWidth": 100 },
                { "sTitle" : "", "mData": "barcode_image", "sWidth": 100, "visible" : false}
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "material_list", "value": material_list});
                return aoData;
            },
            "fnServerData": function (sSource, aoData, fnCallback){
                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "bAutoWidth": false,
            "sAjaxSource": base_url+'material_read',
            "sAjaxDataProp": "material",
            scrollX: true,
            scrollCollapse: true,
            "order": [
                [2, "asc"]
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ideferLoading": 1,
            "bDeferRender": true,
            buttons: {
                buttons: [
                    {
                        extend: 'csv',
                        "oSelectorOpts": { filter: 'applied', order: 'current' },
                        text: 'CSV',
                        className: 'btn btn-default'
                    }, {
                        extend: 'colvis',
                        text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                        className: 'btn bg-blue btn-icon',
                    }
                ]
            },
            initComplete: function () {
                oTable = this;
            }
        });

        $('.datatable-material tbody').on('click', 'a[title="Edit"]', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#material_form')[0].reset();
            $('#material_form input[name="id"]').val(data.id);
            $('#material_form input[name="name"]').val(data.name);
            $('#material_form input[name="upc"]').val(data.upc);
            $('#material_form input[name="barcode_info"]').val(data.barcode_info);
            $('#material_form input[name="size"]').val(data.size);
            $('#material_form input[name="packaging_type"]').val(data.packaging_type);
            $("#barcode_image").attr("src","<?php echo base_url(); ?>/uploads/file/"+data.barcode_image);
            $('#scandiv').removeClass('hidden');
            $('#modal_material').modal('show');
        });

        $('.datatable-material tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'id' : data.id
                    };
                    $.post(base_url+'delete_material', params, function(data, status){
                        if (status == "success") {
                            new PNotify({
                                title: 'Success',
                                text: 'Successfully Removed.',
                                icon: 'icon-checkmark3',
                                type: 'success'
                            });
                            oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                            // oTable.fnDeleteRow(tr);
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: 'Failed.',
                                icon: 'icon-blocked',
                                type: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table.columns.adjust();
            });
        }, 100);

        // External table additions
        // ------------------------------
        $('.bootstrap-select').selectpicker();
        // Launch Uniform styling for checkboxes
        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });



        // Setup validation
        // ------------------------------

        // Initialize

        var validator1 = $("#material_form").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            rules: {
                email: {
                    email: true,
                    required: true
                }
            },
            success: function(label) {
                label.addClass("validation-valid-label").text("Success.")
            },
            submitHandler: function (form) {
                var params={};
                for (i=0; i<form.length; i++) {
                    if (form[i].name != '') {
                        params[form[i].name] = form[i].value;
                    }
                }
                $.post(base_url+'edit_material', params, function(data, status){
                    if (data != "") {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Saved.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        form.reset();
                        oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                        $('#modal_material').modal('hide');
                    } else {
                        new PNotify({
                            title: 'Error',
                            text: data.message,
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                });
            }
        });

        $('#addmaterialbtn').click(function () {
            $('#material_form')[0].reset();
            $('#material_form input[name="id"]').val(0);
            $('#scandiv').addClass('hidden');
            $("#barcode_image").attr("");
        });

    });
    $(function() {


        // Table setup
        // ------------------------------

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable_supplier;
        // Generate content for a column
        var table_supplier = $('.datatable-supplier').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 30,
                    mRender: function (data, type, row, pos) {
                        var info = table_supplier.page.info();
                        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                    }
                },
                { "sTitle" : "Name", "mData": "name", "sWidth": 120 },
                { "sTitle" : "Phone", "mData": "phone", "sWidth": 120 },
                { "sTitle" : "Material", "mData": "material", "sWidth": 120 },
                { "sTitle" : "Email Address", "mData": "email", "sWidth": 120 },
                { "sTitle" : "Street Address", "mData": "street_address", "sWidth": 120 }
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "supplier_list", "value": supplier_list});
                return aoData;
            },
            "fnServerData": function (sSource, aoData, fnCallback){
                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "bAutoWidth": false,
            "sAjaxSource": base_url+'supplier_read',
            "sAjaxDataProp": "supplier",
            scrollX: true,
            scrollCollapse: true,
            "order": [
                [2, "asc"]
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ideferLoading": 1,
            "bDeferRender": true,
            buttons: {
                buttons: [
                    {
                        extend: 'csv',
                        "oSelectorOpts": { filter: 'applied', order: 'current' },
                        text: 'CSV',
                        className: 'btn btn-default'
                    }, {
                        extend: 'colvis',
                        text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                        className: 'btn bg-blue btn-icon',
                    }
                ]
            },
            initComplete: function () {
                oTable_supplier = this;
            }
        });

        $('.datatable-supplier tbody').on('click', 'a[title="Edit"]', function () {
            var data = table_supplier.row($(this).parents('tr')).data();
            $('#supplier_form')[0].reset();
            $('#supplier_form input[name="id"]').val(data.id);
            $('#supplier_form input[name="material"]').val(data.material);
            $('#supplier_form input[name="name"]').val(data.name);
            $('#supplier_form input[name="email"]').val(data.email);
            $('#supplier_form input[name="phone"]').val(data.phone);
            $('#supplier_form input[name="street_address"]').val(data.street_address);
            $('#modal_supplier').modal('show');
        });

        $('.datatable-supplier tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table_supplier.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'ids' : data.id
                    };
                    $.post(base_url+'supplier_delete', params, function(data, status){
                        if (JSON.parse(data)['success'] > 0) {
                            new PNotify({
                                title: 'Success',
                                text: 'Successfully Removed.',
                                icon: 'icon-checkmark3',
                                type: 'success'
                            });
                            oTable_supplier.api().ajax.url(oTable_supplier.fnSettings().sAjaxSource).load();
                            // oTable.fnDeleteRow(tr);
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: 'Failed.',
                                icon: 'icon-blocked',
                                type: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table_supplier.columns.adjust();
            });
        }, 100);

        // External table additions
        // ------------------------------
        $('.bootstrap-select').selectpicker();
        // Launch Uniform styling for checkboxes
        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });



        // Setup validation
        // ------------------------------

        // Initialize

        var validator2 = $("#supplier_form").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            rules: {
                email: {
                    email: true,
                    required: true
                }
            },
            success: function(label) {
                label.addClass("validation-valid-label").text("Success.")
            },
            submitHandler: function (form) {
                var params={};
                for (i=0; i<form.length; i++) {
                    if (form[i].name != '') {
                        params[form[i].name] = form[i].value;
                    }
                }
                $.post(base_url+'supplier_save', params, function(data, status){
                    if (data.success) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Saved.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        form.reset();
                        oTable_supplier.api().ajax.url(oTable_supplier.fnSettings().sAjaxSource).load();
                        $('#modal_supplier').modal('hide');
                    } else {
                        new PNotify({
                            title: 'Error',
                            text: data.message,
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                });
            }
        });

        $('#addsupplierbtn').click(function () {
            $('#supplier_form')[0].reset();
            $('#supplier_form input[name="id"]').val(0);
        });

    });
    $(function() {


        // Table setup
        // ------------------------------

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable_customer;
        // Generate content for a column
        var table_customer = $('.datatable-customer').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 30,
                    mRender: function (data, type, row, pos) {
                        var info = table_customer.page.info();
        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
    }
    },
    { "sTitle" : "Customers", "mData": "customer", "sWidth": 120 },
    { "sTitle" : "Name", "mData": "name", "sWidth": 120 },
    { "sTitle" : "Phone", "mData": "phone", "sWidth": 120 },
    { "sTitle" : "Product", "mData": "product", "sWidth": 120 },
    { "sTitle" : "Street Address", "mData": "street_address", "sWidth": 120 },
    { "sTitle" : "Email Address", "mData": "email", "sWidth": 120 }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({"name": "customer_list", "value": customer_list});
        return aoData;
    },
    "fnServerData": function (sSource, aoData, fnCallback){
        $.ajax({
            "dataType": "json",
            "type": "POST",
            "url": sSource,
            "data": aoData,
            "success": fnCallback
        });
    },
    "bAutoWidth": false,
        "sAjaxSource": base_url+'customer_read',
        "sAjaxDataProp": "customer",
        scrollX: true,
        scrollCollapse: true,
        "order": [
        [2, "asc"]
    ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ideferLoading": 1,
        "bDeferRender": true,
        buttons: {
        buttons: [
            {
                extend: 'csv',
                "oSelectorOpts": { filter: 'applied', order: 'current' },
                text: 'CSV',
                className: 'btn btn-default'
            }, {
                extend: 'colvis',
                text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                className: 'btn bg-blue btn-icon',
            }
        ]
    },
    initComplete: function () {
        oTable_customer = this;
    }
    });

    $('.datatable-customer tbody').on('click', 'a[title="Edit"]', function () {
        var data = table_customer.row($(this).parents('tr')).data();
        $('#customer_form')[0].reset();
        $('#customer_form input[name="id"]').val(data.id);
        $('#customer_form input[name="customer"]').val(data.customer);
        $('#customer_form input[name="name"]').val(data.name);

        $('#customer_form input[name="email"]').val(data.email);
        $('#customer_form input[name="phone"]').val(data.phone);
        $('#customer_form input[name="product"]').val(data.product);
        $('#customer_form input[name="street_address"]').val(data.street_address);
        $('#modal_customer').modal('show');
    });

    $('.datatable-customer tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table_customer.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post(base_url+'customer_delete', params, function(data, status){
                    if (JSON.parse(data)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Removed.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        oTable_customer.api().ajax.url(oTable_customer.fnSettings().sAjaxSource).load();
                        // oTable.fnDeleteRow(tr);
                    } else {
                        new PNotify({
                            title: 'Error',
                            text: 'Failed.',
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                });
            }
        });
    });

    // Adjust columns on window resize
    setTimeout(function() {
        $(window).on('resize', function () {
            table_customer.columns.adjust();
        });
    }, 100);

    // External table additions
    // ------------------------------
    $('.bootstrap-select').selectpicker();
    // Launch Uniform styling for checkboxes
    $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
        $('.ColVis_collection input').uniform();
    });



    // Setup validation
    // ------------------------------

    // Initialize

    var validator3 = $("#customer_form").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        rules: {
            email: {
                email: true,
                required: true
            }
        },
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        submitHandler: function (form) {
            var params={};
            for (i=0; i<form.length; i++) {
                if (form[i].name != '') {
                    params[form[i].name] = form[i].value;
                }
            }
            $.post(base_url+'customer_save', params, function(data, status){
                if (data.success) {
                    new PNotify({
                        title: 'Success',
                        text: 'Successfully Saved.',
                        icon: 'icon-checkmark3',
                        type: 'success'
                    });
                    form.reset();
                    oTable_customer.api().ajax.url(oTable_customer.fnSettings().sAjaxSource).load();
                    $('#modal_customer').modal('hide');
                } else {
                    new PNotify({
                        title: 'Error',
                        text: data.message,
                        icon: 'icon-blocked',
                        type: 'error'
                    });
                }
            });
        }
    });

    $('#addcustomerbtn').click(function () {
        $('#customer_form')[0].reset();
        $('#customer_form input[name="id"]').val(0);
    });

    });
    $(function() {


        // Table setup
        // ------------------------------

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable_record;
        // Generate content for a column
        var table_record = $('.datatable-record').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 100,
                    mRender: function (data, type, row, pos) {
                        var info = table_record.page.info();
                        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                    }
                },
                { "sTitle" : "name", "mData": "name", "sWidth": 100 },
                { "sTitle" : "Description", "mData": "description", "sWidth": 200 },
//                { "sTitle" : "Number", "mData": "number", "sWidth": 200 },
                { "sTitle" : "Active Date", "mData": "version_date", "sWidth": 150},
                { "sTitle" : "Review Date", "mData": "revision_date", "sWidth": 150},
                { "sTitle" : "File", "mData": "file_path", "sWidth": 180,
                    mRender: function (data, type, row) {
                        if (row.file_path != null && row.file_path != ''){
                            return  '<a href="<?php echo base_url(); ?>uploads/Doc/'+row.file_path+'" target="download"><i class="icon-download " aria-hidden="true"></i>Download</a>';
                        }else{
                            return '';
                        }
                    }
                }
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "record_list", "value": record_list});
                return aoData;
            },
            "fnServerData": function (sSource, aoData, fnCallback){
                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "bAutoWidth": false,
            "sAjaxSource": base_url+'record_read',
            "sAjaxDataProp": "record",
            scrollX: false,
            scrollCollapse: true,
            "order": [
                [2, "asc"]
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ideferLoading": 1,
            "bDeferRender": true,
            buttons: {
                buttons: [
                    {
                        extend: 'csv',
                        "oSelectorOpts": { filter: 'applied', order: 'current' },
                        text: 'CSV',
                        className: 'btn btn-default'
                    }, {
                        extend: 'colvis',
                        text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                        className: 'btn bg-blue btn-icon',
                    }
                ]
            },
            initComplete: function () {
                oTable_record = this;
            }
        });

        $('.datatable-record tbody').on('click', 'a[title="Edit"]', function () {
            var data = table_record.row($(this).parents('tr')).data();
            $('#record_form')[0].reset();
            $('#record_form input[name="id"]').val(data.id);
            $('#record_form input[name="name"]').val(data.name);
            $('#record_form input[name="version_date"]').val(data.version_date);
            $('#record_form input[name="revision_date"]').val(data.revision_date);
            $('#record_form textarea[name="description"]').val(data.description);
            $('#record_form input[name="number"]').val(data.number);
            file_path = data.file_path;
            $('#modal_record').modal('show');
        });
        $('.datatable-record tbody').on('click', 'a[title="Detail"]', function () {
            var data = table_record.row($(this).parents('tr')).data();
//            $("#edit_id").val(data.id);
//            editor.setData(data.content);
            //if (CKEDITOR.instances['content']){
            //    //CKEDITOR.instances['content'].destroy();
            //    CKEDITOR.instances['content'].refresh();
            //}
            //$("#content").html(data.content);
            //CKEDITOR.replace('content',
            //    {
            //        fullPage : true,
            //        // extraPlugins : 'docprops'
            //    });
//            $("#modal_content").modal();
        });

        $('.datatable-record tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table_record.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'ids' : data.id
                    };
                    $.post(base_url+'record_delete', params, function(data, status){
                        if (JSON.parse(data)['success'] > 0) {
                            new PNotify({
                                title: 'Success',
                                text: 'Successfully Removed.',
                                icon: 'icon-checkmark3',
                                type: 'success'
                            });
                            oTable_record.api().ajax.url(oTable_record.fnSettings().sAjaxSource).load();
                            // oTable.fnDeleteRow(tr);
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: 'Failed.',
                                icon: 'icon-blocked',
                                type: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table_record.columns.adjust();
            });
        }, 100);

        // External table additions
        // ------------------------------
        $('.bootstrap-select').selectpicker();
        // Launch Uniform styling for checkboxes
        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });



        // Setup validation
        // ------------------------------

        // Initialize

        var validator4 = $("#record_form").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            success: function(label) {
                label.addClass("validation-valid-label").text("Success.")
            },
            submitHandler: function (form) {
                var file = $('input[name="file_name"]')[0].files[0];
                var A = new FormData();
                for (i=0; i<form.length; i++) {
                    if (form[i].name != '') {
                        if(form[i].name == "share"){
                            A.append(form[i].name, $(form[i]).is(':checked') ? 1 : 0);
                        } else{
                            A.append(form[i].name, form[i].value);
                        }
                    }
                }
                if (file) {
                    A.append("file", file);
                }
                var C = new XMLHttpRequest();
                C.open("POST", base_url+'record_save');
                C.onload = function() {
                    var E;
                    E = C.responseText;
                    $('#modal_record').modal('hide');
                    if (JSON.parse(E)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Saved.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        form.reset();
                        oTable_record.api().ajax.url(oTable_record.fnSettings().sAjaxSource).load();

//                        if (!file && file_path == "") {
//                            $('#edit_id').val(JSON.parse(E)['success']);
//                            editor.setData("");
//                            $('#modal_content').modal();
//                        }
                    } else if (E == "FAILED") {
                        new PNotify({
                            title: 'Error',
                            text: 'Failed.',
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                    return;
                };
                C.send(A);
            }
        });

        $('#addrecordbtn').click(function (){
            $('#record_form')[0].reset();
            $('#record_form input[name="id"]').val(0);
        });
    });
    $(function() {


        // Table setup
        // ------------------------------

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable_machine;
        // Generate content for a column
        var table_machine = $('.datatable-machine').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 30,
                    mRender: function (data, type, row, pos) {
                        var info = table_machine.page.info();
                        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                    }
                },
                { "sTitle" : "Name", "mData": "name", "sWidth": 300 },
                { "sTitle" : "Number", "mData": "number", "sWidth": 100 },
                { "sTitle" : "Location", "mData": "location", "sWidth": 100 },
                { "sTitle" : "Last_maintenance", "mData": "last_maintenance", "sWidth": 100 },
                { "sTitle" : "Next_maintenance", "mData": "next_maintenance", "sWidth": 100 }
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "machine_list", "value": machine_list});
                return aoData;
            },
            "fnServerData": function (sSource, aoData, fnCallback){
                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "bAutoWidth": false,
            "sAjaxSource": base_url+'machine_read',
            "sAjaxDataProp": "machine",
            scrollX: true,
            scrollCollapse: true,
            "order": [
                [2, "asc"]
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ideferLoading": 1,
            "bDeferRender": true,
            buttons: {
                buttons: [
                    {
                        extend: 'csv',
                        "oSelectorOpts": { filter: 'applied', order: 'current' },
                        text: 'CSV',
                        className: 'btn btn-default'
                    }, {
                        extend: 'colvis',
                        text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                        className: 'btn bg-blue btn-icon',
                    }
                ]
            },
            initComplete: function () {
                oTable_machine = this;
            }
        });

        $('.datatable-machine tbody').on('click', 'a[title="Edit"]', function () {
            var data = table_machine.row($(this).parents('tr')).data();
            $('#machine_form')[0].reset();
            $('#machine_form input[name="id"]').val(data.id);
            $('#machine_form input[name="name"]').val(data.name);
            $('#machine_form input[name="number"]').val(data.number);
            $('#machine_form input[name="location"]').val(data.location);
            $('#machine_form input[name="last_maintenance"]').val(data.last_maintenance);
            $('#machine_form input[name="next_maintenance"]').val(data.next_maintenance);
            $('#modal_machine').modal('show');
        });

        $('.datatable-machine tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table_machine.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'id' : data.id
                    };
                    $.post(base_url+'delete_machine', params, function(data, status){
                        if (status == "success") {
                            new PNotify({
                                title: 'Success',
                                text: 'Successfully Removed.',
                                icon: 'icon-checkmark3',
                                type: 'success'
                            });
                            oTable_machine.api().ajax.url(oTable_machine.fnSettings().sAjaxSource).load();
                            // oTable.fnDeleteRow(tr);
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: 'Failed.',
                                icon: 'icon-blocked',
                                type: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table_machine.columns.adjust();
            });
        }, 100);

        // External table additions
        // ------------------------------
        $('.bootstrap-select').selectpicker();
        // Launch Uniform styling for checkboxes
        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });



        // Setup validation
        // ------------------------------

        // Initialize

        var validator5 = $("#machine_form").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            rules: {
                email: {
                    email: true,
                    required: true
                }
            },
            success: function(label) {
                label.addClass("validation-valid-label").text("Success.")
            },
            submitHandler: function (form) {
                var params={};
                for (i=0; i<form.length; i++) {
                    if (form[i].name != '') {
                        params[form[i].name] = form[i].value;
                    }
                }
                $.post(base_url+'edit_machine', params, function(data, status){
                    if (data != "") {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Saved.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        form.reset();
                        oTable_machine.api().ajax.url(oTable_machine.fnSettings().sAjaxSource).load();
                        $('#modal_machine').modal('hide');
                    } else {
                        new PNotify({
                            title: 'Error',
                            text: data.message,
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                });
            }
        });

        $('#addmachinebtn').click(function () {
            $('#machine_form')[0].reset();
            $('#machine_form input[name="id"]').val(0);
        });
    });
    $(function() {
        // Table setup
        // ------------------------------
        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            colReorder: true,
            dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Search Name:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        var oTable_procedure;
        // Generate content for a column
        var table_procedure = $('.datatable-procedure').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "aoColumns": [
                {
                    "sTitle" : "NO", "mData": "","sWidth": 70,
                    mRender: function (data, type, row, pos) {
                        var info = table_procedure.page.info();
                        return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                    }
                },
                { "sTitle" : "Procedures Title", "mData": "name", "sWidth": 100 },
                { "sTitle" : "Description", "mData": "description", "sWidth": 250 },
                { "sTitle" : "Active Date", "mData": "version_date", "sWidth": 100},
                { "sTitle" : "Review Date", "mData": "revision_date", "sWidth": 100},
                { "sTitle" : "File", "mData": "file_path", "sWidth": 150,
                    mRender: function (data, type, row) {
                        if (row.file_path != null && row.file_path != ''){
                            return  '<a href="<?php echo base_url(); ?>uploads/Doc/'+row.file_path+'" target="download"><i class="icon-download " aria-hidden="true"></i>Download</a>';
                        }else{
                            return  '';
                        }
                    }
                }
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "procedure_list", "value": procedure_list});
                return aoData;
            },
            "fnServerData": function (sSource, aoData, fnCallback){
                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "bAutoWidth": false,
            "sAjaxSource": base_url+'procedure_read',
            "sAjaxDataProp": "procedure",
            scrollX: false,
            scrollCollapse: true,
            "order": [
                [2, "asc"]
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ideferLoading": 1,
            "bDeferRender": true,
            buttons: {
                buttons: [
                    {
                        extend: 'csv',
                        "oSelectorOpts": { filter: 'applied', order: 'current' },
                        text: 'CSV',
                        className: 'btn btn-default'
                    }, {
                        extend: 'colvis',
                        text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                        className: 'btn bg-blue btn-icon',
                    }
                ]
            },
            initComplete: function () {
                oTable_procedure = this;
            }
        });

        $('.datatable-procedure tbody').on('click', 'a[title="Edit"]', function () {
            var data = table_procedure.row($(this).parents('tr')).data();
            $('#procedure_form')[0].reset();
            $('#procedure_form input[name="id"]').val(data.id);
            $('#procedure_form input[name="name"]').val(data.name);
            $('#procedure_form input[name="version_date"]').val(data.version_date);
            $('#procedure_form input[name="revision_date"]').val(data.revision_date);
            $('#procedure_form textarea[name="description"]').val(data.description);
            file_path = data.file_path;
            $('#modal_procedure').modal('show');
        });
        $('.datatable-procedure tbody').on('click', 'a[title="Detail"]', function () {
            var data = table_procedure.row($(this).parents('tr')).data();
//            $("#edit_id").val(data.id);
//            editor.setData(data.content);
            //if (CKEDITOR.instances['content']){
            //    //CKEDITOR.instances['content'].destroy();
            //    CKEDITOR.instances['content'].refresh();
            //}
            //$("#content").html(data.content);
            //CKEDITOR.replace('content',
            //    {
            //        fullPage : true,
            //        // extraPlugins : 'docprops'
            //    });
//            $("#modal_content").modal();
        });

        $('.datatable-procedure tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table_procedure.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'ids' : data.id
                    };
                    $.post(base_url+'procedure_delete', params, function(data, status){
                        if (JSON.parse(data)['success'] > 0) {
                            new PNotify({
                                title: 'Success',
                                text: 'Successfully Removed.',
                                icon: 'icon-checkmark3',
                                type: 'success'
                            });
                            oTable_procedure.api().ajax.url(oTable_procedure.fnSettings().sAjaxSource).load();
                            // oTable.fnDeleteRow(tr);
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: 'Failed.',
                                icon: 'icon-blocked',
                                type: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Adjust columns on window resize
        setTimeout(function() {
            $(window).on('resize', function () {
                table_procedure.columns.adjust();
            });
        }, 100);

        // External table additions
        // ------------------------------
        $('.bootstrap-select').selectpicker();
        // Launch Uniform styling for checkboxes
        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
            $('.ColVis_collection input').uniform();
        });



        // Setup validation
        // ------------------------------

        // Initialize

        var validator6 = $("#procedure_form").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'validation-error-label',
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            validClass: "validation-valid-label",
            success: function(label) {
                label.addClass("validation-valid-label").text("Success.")
            },
            submitHandler: function (form) {
                var file = $('input[name="file_name"]')[0].files[0];
                var A = new FormData();
                for (i=0; i<form.length; i++) {
                    if (form[i].name != '') {
                        if(form[i].name == "share"){
                            A.append(form[i].name, $(form[i]).is(':checked') ? 1 : 0);
                        } else{
                            A.append(form[i].name, form[i].value);
                        }
                    }
                }
                if (file) {
                    A.append("file", file);
                }
                var C = new XMLHttpRequest();
                C.open("POST", base_url+'procedure_save');
                C.onload = function() {
                    var E;
                    E = C.responseText;
                    if (JSON.parse(E)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Saved.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        form.reset();
                        oTable_procedure.api().ajax.url(oTable_procedure.fnSettings().sAjaxSource).load();
                        $('#modal_procedure').modal('hide');
                        if (!file && file_path == "") {
//                            $('#edit_id').val(JSON.parse(E)['success']);
//                            editor.setData("");
//                            $('#modal_content').modal();
                        }
                    } else if (E == "FAILED") {
                        new PNotify({
                            title: 'Error',
                            text: 'Failed.',
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                    return;
                };
                C.send(A);
            }
        });

        $('#addprocedurebtn').click(function () {
            file_path = "";
            $('#procedure_form input[name="id"]').val(0);
        });

    });

</script>
</body>
</html>
