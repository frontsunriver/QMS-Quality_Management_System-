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

    <style>
        #table_btn {
            position: relative;
            margin-left: 15px;
        }
    </style>

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>

    <script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'ui/moment/moment.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/daterangepicker.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url(JS_URL . 'core/app.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url(JS_URL . 'charts/Chart.js') ?>"></script>
    <!-- /core JS files -->


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

                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h6 class="panel-title">Corrective Action Resolution Log Statistic</h6>
                        </div>
                        <div class="panel-body text-left" style="padding-bottom: 0px;">
                            <div class="form-group">
                                <label style="margin-right:15px">Date Range: </label>
                                <button type="button" class="btn btn-default daterange-all-company">
                                    <i class="icon-calendar22 position-left"></i>
                                    <span></span>
                                    <b class="caret"></b>
                                </button>
                                <input type="hidden" id="company_end">
                                <input type="hidden" id="company_start">
                            </div>
                            <div class="all_company_chart">
                            </div>
                        </div>
                    </div>
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

<script type="text/javascript">
    //date range 
    
    function init_daterange_c(){
        $('#company_start').val(moment().subtract(29, 'days').format('YYYY-MM-DD'));
        $('#company_end').val(moment().format('YYYY-MM-DD'));
        $('.daterange-all-company').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                //minDate: '01/01/2014',
                maxDate: <?php echo date('d/m/Y')?>,
                dateLimit: { days: 1000000000 },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                applyClass: 'btn-small bg-slate',
                cancelClass: 'btn-small btn-default'
            },
            function(start, end) {
                $('.daterange-all-company span').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
                $("#company_start").val(start.format('YYYY-MM-DD'));
                $("#company_end").val(end.format('YYYY-MM-DD'));
                init_all_company_stat();
            }
        );
        $('.daterange-all-company span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));

        $('.all_company_chart').html('<div id="chart_div"></div>');
    }

    function init_all_company_stat() {
        var params = {
            'start':$('#company_start').val(),
            'end':$('#company_end').val()
        };

        $.post("<?= base_url('statistic/company') ?>", params, function(data) {
            $('.all_company_chart').html('<div id="chart_div"></div>');

            var result = data;
            var insertTarget = '#chart_div';
            for (var i = 0; i < result.length; i ++) {
                $('<canvas id="bar-chart' + (i + 1) + '" width="2000" height="300"></canvas>').insertAfter(insertTarget);
                insertTarget = '#bar-chart' + (i + 1);

                var barChartData = {
                    labels: result[i].label,
                    datasets: [{
                        label:"Total Actions Assigned",
                        backgroundColor: "#f89a14",
                        hoverBackgroundColor: "#f89a14",
                        data : result[i].total
                    }, {
                        label:"Total Open Items",
                        backgroundColor: "#1E88E5",
                        hoverBackgroundColor: "#1E88E5",
                        data: result[i].open
                    }, {
                        label:"Total Close Items",
                        backgroundColor: "#4CAF50",
                        hoverBackgroundColor: "#4CAF50",
                        data: result[i].close
                    }, {
                        label:"Total Open Itmes Past Due",
                        backgroundColor: "#F4511E",
                        hoverBackgroundColor: "#F4511E",
                        data: result[i].past
                    }]
                };

                console.log(barChartData);
                    
                var selector = '#bar-chart' + (i + 1);
                $(selector).attr('width', $(selector).parent().width());

                var myBar = new Chart($(selector), {
                    type: 'bar',
                    data: barChartData
                });
            }
        });
    }

    $(function(){
        init_daterange_c();
        init_all_company_stat();

        $("<button type='button' class='btn btn-primary' id='table_btn'>Table</button>").insertAfter(".daterange-all-company");

        $("#table_btn").click(function(){
            history.back();
        });
    });
</script>

</body>

</html>
