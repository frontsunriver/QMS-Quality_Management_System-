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
                <form class="form-horizontal" method="post" action="<?php echo  base_url(); ?>index.php/consultant/add_risk_sign">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Policy</h5>
                        </div>
                        <div class="row">
                            <div class="panel-heading col-md-6">
                                <textarea class="form-control" name="policy" rows="10"><?=$policy?></textarea>
                                <button type="button" class="btn btn-primary" style="margin-top: 10px;" onclick="sign()">Sign</button>
                            </div>
                        </div>
                        <div class="panel-heading">
                            <a type="button" class="btn btn-primary" style="margin: 10px;margin-bottom: 0px;width: 100px;" onclick="window.history.back()">Back</a>
                            <button type="submit" class="btn btn-primary" style="margin: 10px;margin-bottom: 0px;width: 100px;">Finish</button>
                        </div>
                    </div>
                </form>
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
<script>
    var id = "<?=$id?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    function sign(){
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
                            var nicURI = base_url+"save_signature_risk";
                            var A = new FormData();
                            A.append("id", id);
                            A.append("sign", sigData);
                            var C = new XMLHttpRequest();
                            C.open("POST", nicURI);
                            C.onload = function() {
                                var E;
                                E = C.responseText;
                                if (E.indexOf("SUCCESS") >= 0) {
                                    $("#modal_sign").modal("hide");
                                }else{
                                    $("#imgData").html('Sorry! Your signature was not saved');
                                    return;
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
