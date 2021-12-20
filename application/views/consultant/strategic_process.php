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
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->

    <script type="text/javascript">
        $(function() {
            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: '150px',
                    targets: [6 ]
                }],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
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

            // Basic datatable
            $('.datatable-basic').DataTable({
                order: [7,"desc"]
            });

            // Alternative pagination
            $('.datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('.datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            // External table additions
            // ------------------------------

            // Enable Select2 select for the length option
//            $('.dataTables_length select').select2({
//                minimumResultsForSearch: Infinity,
//                width: 'auto'
//            });
        });
    </script>
    <style>
        th{
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
                            <span class="text-semibold"><?= $title ?></span>
                            <div class="pull-right">
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i
                                    class="icon-home2 role-left"></i>Home</a></li>
                        <li>Risk List</li>
                        <li><a href="#"><?= $title ?></a></li>

                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <form id="get_process_list" action = "<?php echo  base_url(); ?>index.php/Consultant/get_strategic_process" method="post">
                <input type="hidden" id="risk_id" name="risk_id" value="<?=$risk_id?>">
                <input type="hidden" id="get_value_swot" name="get_value_swot" value="<?=$swot_id?>">
                <input type="hidden" id="get_value_steep" name="get_value_steep" value="<?=$steep_id?>">
                <input type="hidden" id="get_flag" name="get_flag">
            </form>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">SWOT</span>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="col-md-2" style="padding-top: 10px;"><span>Select Type:</span></div>
                                <div class="col-md-6">
                                    <select class="form-control" name="process_swot_type" id="process_swot_type" onchange="get_process_list('swot')">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <a data-toggle="modal" data-target="#swot_type" class="btn btn-primary">MANAGE</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <?php if ($user_type == "consultant"): ?>
                                        <a onclick="add('swot')" style="float: right" class="btn btn-primary">ADD</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-swot">
                        <thead>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Type</th>
                            <th rowspan="3">Process Owner</th>
                            <th rowspan="3">SWOT Name</th>
                            <th rowspan="3">Description</th>
                            <th rowspan="3">Opportunities</th>
                            <th rowspan="3">Potential hazard</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th rowspan="3"><?=$row?></th>
                            <?php endforeach; ?>
                            <th colspan="<?=count($assess_type)*3?>">Risk Assessment</th>
                            <th rowspan="3" style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        <tr>
                            <?php foreach ($assess_type as $row): ?>
                                <th colspan="3"><?=$row?></th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach ($assess_type as $row): ?>
                                <th>Likelihood</th>
                                <th>Consequence</th>
                                <th>RIsk Rating</th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($swots as $row): ?>
                            <?php $count = 1;?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$row->type?></td>
                                <td><?=$row->process_owner_name?></td>
                                <td><?=$row->name?></td>
                                <td><?=$row->description?></td>
                                <td><?=$row->opportunities?></td>
                                <td><?=$row->potential_hazard?></td>
                                <?php foreach ($assess_type as $item): ?>
                                    <td>
                                        <?php
                                            switch ($item){
                                                case 'Food':
                                                    echo $row->food;
                                                    break;
                                                case 'Environmental':
                                                    echo $row->environmental;
                                                    break;
                                                case 'TACCP':
                                                    echo $row->TACCP;
                                                    break;
                                                case 'Quality':
                                                    echo $row->quality;
                                                    break;
                                                case 'Safety':
                                                    echo $row->safety;
                                                    break;
                                                case 'VACCP':
                                                    echo $row->VACCP;
                                                    break;
                                            }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <?php foreach ($assess_type as $item): ?>
                                    <?php $temp_like = '';$temp_conse = '';$temp_value = '';?>
                                    <?php foreach ($ratings as $rating): ?>
                                        <?php if ($rating->process_id == $row->id): ?>
                                            <?php
                                            switch ($item){
                                                case 'Food':
                                                    $temp_like =  $rating->food_like;
                                                    $temp_conse =  $rating->food_conse;
                                                    $temp_value =  $rating->food_value;
                                                    break;
                                                case 'Environmental':
                                                    $temp_like =  $rating->environmental_like;
                                                    $temp_conse =  $rating->environmental_conse;
                                                    $temp_value =  $rating->environmental_value;
                                                    break;
                                                case 'TACCP':
                                                    $temp_like =  $rating->taccp_like;
                                                    $temp_conse =  $rating->taccp_conse;
                                                    $temp_value =  $rating->taccp_value;
                                                    break;
                                                case 'Quality':
                                                    $temp_like =  $rating->quality_like;
                                                    $temp_conse =  $rating->quality_conse;
                                                    $temp_value =  $rating->quality_value;
                                                    break;
                                                case 'Safety':
                                                    $temp_like =  $rating->safety_like;
                                                    $temp_conse =  $rating->safety_conse;
                                                    $temp_value =  $rating->safety_value;
                                                    break;
                                                case 'VACCP':
                                                    $temp_like =  $rating->vaccp_like;
                                                    $temp_conse =  $rating->vaccp_conse;
                                                    $temp_value =  $rating->vaccp_value;
                                                    break;
                                            }
                                            ?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                    <td>
                                        <select id="<?=$row->id?>-<?=$item?>-like" class="form-control" name="<?=$item?>" onchange="change(<?=$row->id?>,'<?=$item?>','like')">
                                            <option value="0" <?php if ($temp_like == 0): ?>selected<?php endif;?>>N/A</option>
                                            <?php foreach ($likelihood as $like): ?>
                                                <option value="<?=$like->id?>" <?php if ($like->id == $temp_like): ?>selected<?php endif;?>><?=$like->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="<?=$row->id?>-<?=$item?>-conse" class="form-control" name="<?=$item?>" onchange="change(<?=$row->id?>,'<?=$item?>','conse')">
                                            <option value="0" <?php if ($temp_conse == 0): ?>selected<?php endif;?>>N/A</option>
                                            <?php foreach ($consequence as $conse): ?>
                                                <option value="<?=$conse->id?>" <?php if ($conse->id == $temp_conse): ?>selected<?php endif;?>><?=$conse->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td id="<?=$row->id?>-<?=$item?>-value"><?php if ($temp_value == ""): ?>N/A<?php else:?><?=$temp_value?><?php endif;?></td>
                                <?php endforeach; ?>
                                <td>
                                    <ul class="icons-list">
                                        <li><a href="#" onclick="edit(<?=$row->id?>,'swot')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                        <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                        <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>" class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <?php $count++;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">STEEPLMR</span>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="col-md-2" style="padding-top: 10px;"><span>Select Type:</span></div>
                                <div class="col-md-6">
                                    <select class="form-control" name="process_steep_type" id="process_steep_type" onchange="get_process_list('steep')">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <a data-toggle="modal" data-target="#steep_type" class="btn btn-primary">MANAGE</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <?php if ($user_type == "consultant"): ?>
                                        <a onclick="add('steep')" style="float: right" class="btn btn-primary">ADD</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-steep">
                        <thead>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Type</th>
                            <th rowspan="3">Process Owner</th>
                            <th rowspan="3">STEEP Name</th>
                            <th rowspan="3">Description</th>
                            <th rowspan="3">Opportunities</th>
                            <th rowspan="3">Potential hazard</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th rowspan="3"><?=$row?></th>
                            <?php endforeach; ?>
                            <th colspan="<?=count($assess_type)*3?>">Risk Assessment</th>
                            <th rowspan="3" style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        <tr>
                            <?php foreach ($assess_type as $row): ?>
                                <th colspan="3"><?=$row?></th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach ($assess_type as $row): ?>
                                <th>Likelihood</th>
                                <th>Consequence</th>
                                <th>RIsk Rating</th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($steeps as $row): ?>
                            <?php $count = 1;?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$row->type?></td>
                                <td><?=$row->process_owner_name?></td>
                                <td><?=$row->name?></td>
                                <td><?=$row->description?></td>
                                <td><?=$row->opportunities?></td>
                                <td><?=$row->potential_hazard?></td>
                                <?php foreach ($assess_type as $item): ?>
                                    <td>
                                        <?php
                                        switch ($item){
                                            case 'Food':
                                                echo $row->food;
                                                break;
                                            case 'Environmental':
                                                echo $row->environmental;
                                                break;
                                            case 'TACCP':
                                                echo $row->TACCP;
                                                break;
                                            case 'Quality':
                                                echo $row->quality;
                                                break;
                                            case 'Safety':
                                                echo $row->safety;
                                                break;
                                            case 'VACCP':
                                                echo $row->VACCP;
                                                break;
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <?php foreach ($assess_type as $item): ?>
                                    <?php $temp_like = '';$temp_conse = '';$temp_value = '';?>
                                    <?php foreach ($ratings as $rating): ?>
                                        <?php if ($rating->process_id == $row->id): ?>
                                            <?php
                                            switch ($item){
                                                case 'Food':
                                                    $temp_like =  $rating->food_like;
                                                    $temp_conse =  $rating->food_conse;
                                                    $temp_value =  $rating->food_value;
                                                    break;
                                                case 'Environmental':
                                                    $temp_like =  $rating->environmental_like;
                                                    $temp_conse =  $rating->environmental_conse;
                                                    $temp_value =  $rating->environmental_value;
                                                    break;
                                                case 'TACCP':
                                                    $temp_like =  $rating->taccp_like;
                                                    $temp_conse =  $rating->taccp_conse;
                                                    $temp_value =  $rating->taccp_value;
                                                    break;
                                                case 'Quality':
                                                    $temp_like =  $rating->quality_like;
                                                    $temp_conse =  $rating->quality_conse;
                                                    $temp_value =  $rating->quality_value;
                                                    break;
                                                case 'Safety':
                                                    $temp_like =  $rating->safety_like;
                                                    $temp_conse =  $rating->safety_conse;
                                                    $temp_value =  $rating->safety_value;
                                                    break;
                                                case 'VACCP':
                                                    $temp_like =  $rating->vaccp_like;
                                                    $temp_conse =  $rating->vaccp_conse;
                                                    $temp_value =  $rating->vaccp_value;
                                                    break;
                                            }
                                            ?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                    <td>
                                        <select id="<?=$row->id?>-<?=$item?>-like" class="form-control" name="<?=$item?>" onchange="change(<?=$row->id?>,'<?=$item?>','like')">
                                            <option value="0" <?php if ($temp_like == 0): ?>selected<?php endif;?>>N/A</option>
                                            <?php foreach ($likelihood as $like): ?>
                                                <option value="<?=$like->id?>" <?php if ($like->id == $temp_like): ?>selected<?php endif;?>><?=$like->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="<?=$row->id?>-<?=$item?>-conse" class="form-control" name="<?=$item?>" onchange="change(<?=$row->id?>,'<?=$item?>','conse')">
                                            <option value="0" <?php if ($temp_conse == 0): ?>selected<?php endif;?>>N/A</option>
                                            <?php foreach ($consequence as $conse): ?>
                                                <option value="<?=$conse->id?>" <?php if ($conse->id == $temp_conse): ?>selected<?php endif;?>><?=$conse->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td id="<?=$row->id?>-<?=$item?>-value"><?php if ($temp_value == ""): ?>N/A<?php else:?><?=$temp_value?><?php endif;?></td>
                                <?php endforeach; ?>
                                <td>
                                    <ul class="icons-list">
                                        <li><a href="#" onclick="edit(<?=$row->id?>,'steep')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                        <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                        <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>"  class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <?php $count++;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a type="button" class="btn btn-primary" style="margin: 10px;margin-bottom: 0px;width: 100px;" onclick="window.history.back()">Back</a>
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
<div id="modal_process" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Internal and External Info</h5>
            </div>

            <form id="form_process" action = "<?php echo  base_url(); ?>index.php/Consultant/add_process_strategic" method="post">
                <input type="hidden" name="id">
                <input type="hidden" name="risk_id" value="<?=$risk_id?>">
                <input type="hidden" name="flag">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Type</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control" name="edit_swot_type" id="edit_swot_type">
                                        <?php foreach ($swot_type as $row): ?>
                                            <option value="<?=$row->name?>"><?=$row->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="form-control" name="edit_steep_type" id="edit_steep_type">
                                        <?php foreach ($steep_type as $row): ?>
                                            <option value="<?=$row->name?>"><?=$row->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Process Owner</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control" name="process_owner" id="process_owner" required>
                                        <?php foreach ($employees as $row): ?>
                                            <option value="<?=$row->employee_id?>"><?=$row->employee_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label id="edit_name">Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Name" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="description" placeholder="description" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Opportunities</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Opportunities" name="opportunities" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Potential hazard</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Potential hazard" name="potential_hazard" class="form-control" required>
                                </div>
                            </div>
                            <?php foreach ($assess_type as $row): ?>
                                <div class="col-sm-12" style="margin-top: 10px;">
                                    <div class="col-sm-3" style="padding-top: 10px;">
                                        <label><?=$row?></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="<?=$row?>" name="<?=$row?>" class="form-control" required>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datatable-scroll').attr('style','overflow-x:scroll;');
    });
    function add(flag){
        $('#form_process')[0].reset();
        $('#form_process input[name="id"]').val('0');
        $('#form_process input[name="flag"]').val(flag);
        $('#form_process select[name="edit_swot_type"]').val('');
        $('#form_process select[name="edit_steep_type"]').val('');
        $('#form_process select[name="process_owner"]').val('');
        $('#form_process input[name="name"]').val('');
        $('#form_process textarea[name="description"]').html('');
        $('#form_process input[name="opportunities"]').val('');
        $('#form_process input[name="potential_hazard"]').val('');
        $('#form_process input[name="Food"]').val('');
        $('#form_process input[name="Environmental"]').val('');
        $('#form_process input[name="TACCP"]').val('');
        $('#form_process input[name="Quality"]').val('');
        $('#form_process input[name="Safety"]').val('');
        $('#form_process input[name="VACCP"]').val('');
        if (flag == 'swot'){
            $('#edit_name').html("SWOT Name");
            $('#edit_steep_type').css("display","none");
            $('#edit_swot_type').css("display","block");
        }else{
            $('#edit_name').html("STEEP Name");
            $('#edit_swot_type').css("display","none");
            $('#edit_steep_type').css("display","block");
        }
        $('#modal_process').modal();
    }
    function change(id,type,flag){
        var value = $("#"+id+"-"+type+"-"+flag).val();
        $.ajax({
            type: 'POST',
            url: '../change_process_rating',
            data : {
                id:id,
                type:type,
                value:value,
                flag:flag,
            },
            success : function(data) {
                data = JSON.parse(data);
                $("#"+id+"-"+type+"-value").html(data['value']);
            }
        });
    }
    function edit(val,type){
        $.ajax({
            type: "POST",
            url: "<?php echo  base_url(); ?>index.php/Consultant/find_process",
            data:{ 'id' : val,'type':type},
            success: function(data) {
                var datas = $.parseJSON(data);
                $('#form_process input[name="id"]').val(val);
                $('#form_process input[name="flag"]').val(type);
                $('#form_process select[name="edit_swot_type"]').val(datas.type);
                $('#form_process select[name="edit_steep_type"]').val(datas.type);
                $('#form_process select[name="process_owner"]').val(datas.process_owner);
                $('#form_process input[name="name"]').val(datas.name);
                $('#form_process textarea[name="description"]').html(datas.description);
                $('#form_process input[name="opportunities"]').val(datas.opportunities);
                $('#form_process input[name="potential_hazard"]').val(datas.potential_hazard);
                $('#form_process input[name="Food"]').val(datas.food);
                $('#form_process input[name="Environmental"]').val(datas.environmental);
                $('#form_process input[name="TACCP"]').val(datas.TACCP);
                $('#form_process input[name="Quality"]').val(datas.quality);
                $('#form_process input[name="Safety"]').val(datas.safety);
                $('#form_process input[name="VACCP"]').val(datas.VACCP);
                if (type == 'swot'){
                    $('#edit_name').html("SWOT Name");
                    $('#edit_steep_type').css("display","none");
                    $('#edit_swot_type').css("display","block");
                }else{
                    $('#edit_name').html("STEEP Name");
                    $('#edit_swot_type').css("display","none");
                    $('#edit_steep_type').css("display","block");
                }
                $('#modal_process').modal();
            }
        });
    }
    function get_process_list(flag){
        $('#get_flag').val(flag);
        if (flag == "swot"){
            $('#get_value_swot').val($('#process_swot_type').val());
            $('#get_value_steep').val($('#process_steep_type').val());
        }else{
            $('#get_value_swot').val($('#process_swot_type').val());
            $('#get_value_steep').val($('#process_steep_type').val());
        }
        $('#get_process_list').submit();
    }
    function delete_process(id){
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'id' : id
                };
                $.post('<?php echo  base_url(); ?>index.php/Consultant/delete_process', params, function(data, status){
                    if (JSON.parse(data)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Removed.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        $('#get_process_list').submit();
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
    }
</script>

</body>
<?php $this->load->view('consultant/manage/swot_type'); ?>
<?php $this->load->view('consultant/manage/steep_type'); ?>
</html>
