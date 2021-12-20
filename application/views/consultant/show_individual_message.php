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
                        <h5 class="panel-title"><?=@$title_msz->title?>

                            <a class="btn btn-primary pull-right" onclick="printDiv('ptn');" > Print</a></h5>

                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" id="ptn">
                                <!-- Basic layout -->
                                <div class="panel panel-flat">
                                    <div class="panel-body">
                                        <ul class="media-list chat-list content-group">
                                            <?php
                                            $consultant_id = $this->session->userdata('consultant_id');
                                            $user_type = $this->session->userdata('user_type');
                                            $employee_id = $this->session->userdata('employee_id');
                                            foreach ($message as $messages) { ?>
                                                <?php if ($user_type == "consultant"):?>
                                                    <?php
                                                    if ($messages->from_role=='consultant') { ?>
                                                        <li class="media reversed" style="margin-right: 10px;">
                                                            <div class="media-body" >
                                                                <div class="media-content"><?=$messages->message?>.</div>
                                                                <span class="media-annotation display-block mt-10"><?php  echo $this->session->userdata('username'); ?>  (Consultant Owner)<i class="icon-user position-right text-muted"></i></span>
                                                            </div>
                                                        </li>
                                                    <?php } else{?>
                                                        <?php
                                                        $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->from_user'")->row();
                                                        $name=$user->employee_name;
                                                        ?>
                                                        <li class="media" style="margin-left: 10px;">
                                                            <div class="media-body">
                                                                <div class="media-content"><?=$messages->message?></div>
                                                                <span class="media-annotation display-block mt-10"> <i class="icon-user position-right text-muted"></i> <?=$name?>  </span>
                                                            </div>
                                                        </li>
                                                    <?php }?>
                                                <?php else:?>
                                                    <?php
                                                    if (@$messages->from_role=='consultant') { ?>
                                                        <li class="media " style="margin-right: 10px;">
                                                            <div class="media-body" >
                                                                <div class="media-content"><?=@$messages->message?>.</div>
                                        <span class="media-annotation display-block mt-10"><?php
                                            $consultant_id = $this->session->userdata('consultant_id');
                                            echo $from_users=@$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->username; ?>  (Consultant Owner)<i class="icon-user position-right text-muted"></i></span>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    } elseif($messages->from_user==$employee_id){?>
                                                        <?php
                                                        $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->from_user'")->row();
                                                        $name=$user->employee_name;
                                                        ?>
                                                        <li class="media reversed" style="margin-left: 10px;">
                                                            <div class="media-body">
                                                                <div class="media-content"><?=@$messages->message?></div>
                                                                <span class="media-annotation display-block mt-10"> <i class="icon-user position-right text-muted"></i> <?=$name?>  </span>
                                                            </div>
                                                        </li>
                                                    <?php } else{?>
                                                        <?php
                                                        $user=@$this->db->query("select * from `employees` where `employee_id`='$messages->from_user'")->row();
                                                        $name=$user->employee_name;
                                                        ?>
                                                        <li class="media" style="margin-left: 10px;">
                                                            <div class="media-body">
                                                                <div class="media-content"><?=@$messages->message?></div>
                                                                <span class="media-annotation display-block mt-10"> <i class="icon-user position-right text-muted"></i> <?=$name?>  </span>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                <?php endif;?>
                                            <?php  }?>
                                        </ul>
                                        <form action="<?php echo base_url();?>index.php/Consultant/mails_to_indi_data" method="post">
                                            <textarea  class="form-control content-group" rows="3" cols="1" name="message" placeholder="Enter your message..."></textarea>
                                            <input type="hidden" name="title" value="<?=$title_msz->title?>">
                                            <input type="hidden" name="to_user" value="<?=$title_msz->to_user?>">
                                            <input type="hidden" name="data_id" value="<?=$title_msz->id?>">

                                            <div class="row">
                                                <div class="col-xs-6">
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right"><b><i class="icon-circle-right2"></i></b> Send</button>
                                                </div>
                                            </div>
                                        </form>

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
<script type="text/javascript">
    function find(val){
        if (val==0) {
            $("#cust_name").val('');
            $("#address").val('');
            $("#city").val('');
            $("#state").val('');
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/findcustomer",
            data:{ 'id' : val},
            success: function(data) {
                var datas = $.parseJSON(data)
                $("#cust_name").val(datas.name);
                $("#address").val(datas.address);
                $("#city").val(datas.city);
                $("#state").val(datas.state);
            }
        });
    }
</script>

<script type="text/javascript">
    function findresponsible(val){
        if (val==0) {
            $("#position").val('');
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/findresponsible",
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


        if($("#correction").val() == "TBD"){
            bootbox.alert("Please input CORRECTION field");
            return;
        }
        if($("#business_impact").val() == "TBD"){
            bootbox.alert("Please input Grade of Non-conformity field");
            return;
        }
        if($("#root_cause").val() == "TBD"){
            bootbox.alert("Please input ROOT CAUSE field");

            return;
        }
        if($("#action_plan").val() == "TBD"){
            bootbox.alert("Please input CORRECTIVE ACTION PLAN field");
            return;
        }
        if($("#corrective_action").val() == "TBD"){
            bootbox.alert("Please input CORRECTIVE ACTION field");

            return;
        }

        if($("#verification_effectiveness").val() == "TBD"){
            bootbox.alert("Please input  Verification of Effectiveness field");
            return;
        }

        var flag1 = document.getElementById("verification_flag_yes").checked;
        var flag2 = document.getElementById("verification_flag_no").checked;

        if(!flag1 && !flag2) {
            bootbox.alert("Please Select  Verification of Effectiveness Flag field");
            return;
        }


        var dialog = bootbox.dialog({
            title: 'Verification Form Question',
            message: "<p>If your action involves a nonconformity related to a record management issue or the need for additional training a verification form is needed to verify the training or discussion between the supervisor and involved parties. This document must be completed and signed by all involved  before the action can be closed</p> <h5>Does your action require this form ?</h5>",
            size: 'small',
            buttons: {
                cancel: {
                    label: "NO",
                    className: 'btn-danger',
                    callback: function(){
                        // dialog.modal('hide');
                        $("#verification_question_flag").val("1");
                        $( "#target" ).submit();
                    }
                },

                ok: {
                    label: "YES",
                    className: 'btn-info',
                    callback: function(){
                        $("#verification_question_flag").val("2");
                        $( "#target" ).submit();
                    }
                }
            }


        });

    });

</script>

<script type="text/javascript">

    console.clear();

    function validateForm(){

        return true;
    }

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
</body>

</html>
