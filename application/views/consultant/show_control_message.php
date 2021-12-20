<?php $this->load->view('consultant/header.php'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>

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
                            <img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;"><?=$title?></h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
                        <li>Inbox</li>
                        <li>Contrl Inbox</li>
                        <li class="active"><?=$title?></li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                <!-- Form horizontal -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">CURRENT CONTROL INFORMATION

                            <a class="btn btn-primary pull-right" onclick="printDiv('ptn');" > Print</a></h5>

                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="20%">
                                            <span class="">Control Name:</span>
                                        </td>
                                        <td width="80%">
                                            <span class=""><?=$control_data->name?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="">Control Plan:</span>
                                        </td>
                                        <td>
                                            <span class=""><?=$control_data->plan?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="">Action:
                                            </span>
                                        </td>
                                        <td>
                                            <span class=""><?=$control_data->action_name?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="">Assessment:
                                            </span>
                                        </td>
                                        <td>
                                            <span class=""><?=$control_data->assessment_name?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="">Review Date:</span>
                                        </td>
                                        <td>
                                            <span class=""><?=$control_data->review_date?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div class="text-center" style="margin-top: 20px;">
                                                <a data-toggle="modal" data-target="#modal_send_message" class="btn btn-info">Send Message</a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6" id="ptn">
                                <!-- Basic layout -->

                                <div class="panel panel-flat">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">Messages</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="reload"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <ul class="media-list chat-list content-group">

                                            <?php
                                            $consultant_id = $this->session->userdata('consultant_id');
                                            $employee_id = $this->session->userdata('employee_id');
                                            $user_type = $this->session->userdata('user_type');
                                            foreach ($message as $messages) { ?>
                                                <?php if ($user_type == "consultant"):?>
                                                    <?php
                                                    if (($messages->sender_id == $consultant_id) && ($messages->sender_role == 'Consultant')) { ?>
                                                        <li class="media reversed" style="margin-right: 10px;">
                                                            <div class="media-body" >
                                                                <div class="media-content"><?=$messages->message?>.</div>
                                                                <span class="media-annotation display-block mt-10"><?php  echo $this->session->userdata('username'); ?>  (Consultant Owner)<i class="icon-user position-right text-muted"></i></span>
                                                            </div>
                                                        </li>
                                                    <?php } else{?>
                                                        <?php
                                                        $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->sender_id'")->row();
                                                        $name=$user->employee_name;
                                                        ?>
                                                        <li class="media" style="margin-left: 10px;">
                                                            <div class="media-body">
                                                                <div class="media-content"><?=$messages->message?></div>
                                                                <span class="media-annotation display-block mt-10"> <i class="icon-user position-right text-muted"></i> <?=$name?> (<?=$messages->sender_role?>) </span>
                                                            </div>
                                                        </li>
                                                    <?php }?>
                                                <?php else:?>
                                                    <?php
                                                    if (($messages->sender_id == $employee_id) && ($messages->sender_role == $user_type)) {
                                                        $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->sender_id'")->row();
                                                        $name=$user->employee_name;
                                                        ?>

                                                        <li class="media reversed" style="margin-right: 10px;">
                                                            <div class="media-body" >
                                                                <div class="media-content"><?=$messages->message?>.</div>
                                                                <span class="media-annotation display-block mt-10"><?=$name?>  (<?=$messages->sender_role?>)<i class="icon-user position-right text-muted"></i></span>
                                                            </div>

                                                        </li>

                                                    <?php } else{ ?>
                                                        <?php
                                                        if($messages->sender_role == 'Consultant') {
                                                            $user=@$this->db->query("select * from `consultant` where `consultant_id`='$messages->sender_id'")->row();
                                                            $name = $user->consultant_name;
                                                            $role = 'Consultant Owner';
                                                        } else {
                                                            $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->sender_id'")->row();
                                                            $name=$user->employee_name;
                                                            $role = $messages->sender_role;
                                                        }
                                                        ?>
                                                        <li class="media" style="margin-left: 10px;">
                                                            <div class="media-body">
                                                                <div class="media-content"><?=$messages->message?></div>
                                                                <span class="media-annotation display-block mt-10"> <i class="icon-user position-right text-muted"></i> <?=$name?> (<?=$role?>) </span>
                                                            </div>
                                                        </li>
                                                    <?php }?>
                                                <?php endif;?>
                                            <?php  }?>

                                        </ul>

                                    </div>
                                </div>
                                <!-- /basic layout -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /form horizontal -->


                <!-- Footer -->

                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<script>
    shortcut.add("ctrl+s", function() {

        $("#save").click()
    });
    shortcut.add("ctrl+r", function() {

        $("#reset").click()
    });
</script>


<script type="text/javascript">

    console.clear();

    function validateForm(){

        return true;
    }

</script>

<!-- Primary modal -->
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
                <button type="button" class="btn btn-primary" onclick="sendMessage('<?=$control_data->id?>');"><i class="icon-reply role-right"></i> Send</button>
            </div>
        </div>
    </div>
</div>
<!-- /primary modal -->

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
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
                    location.href = "<?php echo base_url(); ?>index.php/Consultant/show_control_message/<?=$control_data->id?>";
                }
            });
        }
    }
</script>
</body>

</html>
