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
                <!-- Basic datatable -->
                <div class="panel" style="min-height: 60px;">
                    <div style="min-height: 10px;height: 10%;"></div>
                    <div style="height: 80%;padding-left: 1%;padding-right: 1%;">
                        <a data-toggle="modal" data-target="#modal_send_message" class="btn btn-primary btn-sm"><i class="icon-mail5"></i> Send Message</a>
                        <a type="button" class="btn btn-info btn-sm" href="<?php echo base_url(); ?>index.php/Consultant/show_control_message/<?=$control_id?>">
                            <i class="icon-mail-read"></i> View Message
                        </a>
                    </div>
                    <div style="min-height: 10px;height: 10%;"></div>
                </div>
                <div class="panel panel-flat">
                <form id="submit_form" action = "<?php echo  base_url(); ?>index.php/Consultant/submit_monitoring" method="post">
                    <input type="hidden" name="control_id" value="<?=$control_id?>">
                    <input type="hidden" name="risk_type" value="<?=$risk_type?>">

                    <input type="hidden" name="sign_info" id="sign_info"/>

                    <div class="panel-heading">
                        <h5 class="panel-title">Manage Control</h5>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                            <label style="padding-left: 3px;">
                                <?php if ($risk_type == 0 && $type_flag == 0): ?>
                                    Issues 1
                                <?php elseif ($risk_type == 0 && $type_flag == 1): ?>
                                    Needs and Expectation 1
                                <?php else:?>
                                    Process1 Name
                                <?php endif;?>
                            </label>
                            <textarea placeholder="<?php if ($risk_type == 0): ?>Issues 1<?php else:?>Risk1<?php endif;?>" name="issues1" class="form-control" required ><?=$control->issues1?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0 && $type_flag == 0): ?>
                                Issues 2
                            <?php elseif ($risk_type == 0 && $type_flag == 1): ?>
                                Needs and Expectation 2
                            <?php else:?>
                                Process2 Name
                            <?php endif;?>
                        </label>
                        <textarea placeholder="<?php if ($risk_type == 0): ?>Issues 2<?php else:?>Risk2<?php endif;?>" name="issues2" class="form-control" required ><?=$control->issues2?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">Control Monitoring</label>
                        <input type="text" class="form-control" value = "<?=$control->name?>" disabled>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0): ?>
                                Functional Area
                            <?php else:?>
                                AREA/SYSTEM Monitered
                            <?php endif;?>
                        </label>
                        <textarea placeholder="Functional Area" name="functional_area" class="form-control"><?=$control->functional_area?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">Monitor</label>
                        <select class="form-control" name="responsible_party" id="responsible_party">
                            <?php foreach ($employees as $row): ?>
                                <option value="<?=$row->employee_id?>" <?php if ($control->responsible_party == $row->employee_id): ?><?php echo "selected";?><?php endif;?>><?=$row->employee_name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0): ?>
                                Responsible Person
                            <?php else:?>
                                Process Owner
                            <?php endif;?>
                        </label>
                        <select class="form-control" name="sme" id="sme">
                            <?php foreach ($employees as $row): ?>
                                <option value="<?=$row->employee_id?>" <?php if ($control->sme == $row->employee_id): ?><?php echo "selected";?><?php endif;?>><?=$row->employee_name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="padding: 20px;" class="col-sm-12">
                        <?php if(isset($monitoring_access)): ?>
                        <button type="button" id="new_control" class="btn btn-primary" style="margin-right: 20px;" data-toggle="modal" data-target="#modal_monitoring">
                            ADD</button>
                        <?php endif; ?>
                    </div>

                    <table class="table datatable-monitoring">
                    </table>
                    <div style="padding: 20px;" class="col-sm-12">
                        <a type="button" class="btn btn-primary" style="margin-bottom: 0px;width: 100px;" onclick="window.history.back()">Back</a>
                        <?php if ($risk_type == 0): ?>
                            <button type="button" onclick="submit_control_stra()" class="btn btn-primary" style="margin-right: 20px;">Finish</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary" style="margin-right: 20px;">Next</button>
                        <?php endif;?>
                    </div>
                </form>
                </div>
                <!-- /basic datatable -->

                <!-- User form modal -->
                <div id="modal_monitoring" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Monitoring Info</h5>
                            </div>
                            <form id="form_monitoring">
                                <input type="hidden" class="form-control" name="id">
                                <input type="hidden" name="nonform_ids" id="nonform_ids" />
                                <input type="hidden" class="form-control" name="control_id" value="<?=$control_id?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Monitoring Area</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea placeholder="Monitoring Area" name="area" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Monitoring Criteria</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea placeholder="Monitoring Criteria" name="criteria" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea placeholder="Description" id="description" name="description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-6" style="padding-top: 10px;">
                                                    <label>Checkbox to verify</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="radio" class="form-control" name="monitor_status" style="height: 20px;" value="0" onchange="change_description(0)">
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-6" style="padding-top: 10px;">
                                                    <label>Checkbox if Nonconformity is Found</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="radio" class="form-control" name="monitor_status" style="height: 20px;" value="1" onchange="change_description(1)">
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">OK</button>
                                </div>
                            </form>
                        </div>
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
<div id="modal_send_message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-envelope  role-right"></i>  Send Message</h6>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label>Message: </label>
                            <textarea class="form-control" name="message" id="message"></textarea>
                            <span id="message_err" style="color:red;"></span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendMessage('<?=$control_id?>');"><i class="icon-reply role-right"></i> Send</button>
            </div>
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

<!-- /page container -->
<script type="text/javascript" src="<?=base_url();?>assets/js/user/manage_control.js"></script>
<script>
    var ismanager = false;
    <?php if(isset($monitoring_access)) : ?>
    ismanager = true;
    <?php endif; ?>
    var control_id = "<?=$control_id?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    function change_description(type){
        if (type == 0){
            $("#description").prop("disabled",true);
            $("#description").val('');
        }else{
            $("#description").prop("disabled",false);
        }
    }
    function sendMessage(val) {
        var message = $('#message').val();
        if(message.length == 0) {
            $("#message_err").html('* this field is required');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Consultant/send_control_message",
                data:{ 'control_id' : val, 'message' : message},
                success: function(data) {
                    var dialog = bootbox.dialog({
                        message: "Successfully sended.",
                        size: 'small',
                        buttons: {
                            cancel: {
                                label: "Ok",
                                className: 'btn-danger',
                                callback: function() {
                                    dialog.modal('hide');
                                    $('#modal_send_message').modal('hide');
                                }
                            }
                        }
                    });
                }
            });
        }
    }

    function submit_control_stra(){
        $("#modal_sign").modal();
    }

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
                            var nicURI = base_url+"save_signature_monitoring";
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

</script>
</body>
</html>
