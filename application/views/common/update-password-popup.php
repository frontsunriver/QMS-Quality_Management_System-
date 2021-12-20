<style type="text/css">
	.help-tip{
	    position: relative;
	    /*top: 18px;
	    right: 18px;*/
	    text-align: center;
	    background-color: #BCDBEA;
	    border-radius: 50%;
	    width: 24px;
	    height: 24px;
	    font-size: 14px;
	    line-height: 26px;
	    cursor: default;
	}

	.help-tip:before{
	    content:'?';
	    font-weight: bold;
	    color:#fff;
	}

	.help-tip:hover p{
	    display:block;
	    transform-origin: 100% 0%;

	    -webkit-animation: fadeIn 0.3s ease-in-out;
	    animation: fadeIn 0.3s ease-in-out;

	}

	.help-tip p {
	    display: none;
	    text-align: left;
	    background-color: #1E2021;
	    padding: 15px;
	    width: 300px;
	    position: absolute;
	    border-radius: 3px;
	    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
	    right: -4px;
	    color: #FFF;
	    font-size: 12px;
	    line-height: 25px;
	    z-index: 99;
	}

	.help-tip p:before{ /* The pointer of the tooltip */
	    position: absolute;
	    content: '';
	    width:0;
	    height: 0;
	    border:6px solid transparent;
	    border-bottom-color:#1E2021;
	    right:10px;
	    top:-12px;
	}

	.help-tip p:after{ /* Prevents the tooltip from being hidden */
	    width:100%;
	    height:40px;
	    content:'';
	    position: absolute;
	    top:-40px;
	    left:0;
	}

	/* CSS animation */

	@-webkit-keyframes fadeIn {
	    0% { 
	        opacity:0; 
	        transform: scale(0.6);
	    }

	    100% {
	        opacity:100%;
	        transform: scale(1);
	    }
	}

	@keyframes fadeIn {
	    0% { opacity:0; }
	    100% { opacity:100%; }
	}

	.form-group.float-right {
	    float: right;
	    margin: -67px 13px 0px 0px;
	    position: relative;
	    top: 37px;
	}
</style>

<div id="modal_theme_password_update" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title"><i class="icon-key text-muted"></i> Update Password</h6>
				<h6 class="modal-title">(For the security prospective , We recommend you to update your password)</h6>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger print-error-msg" style="display:none"></div>
				<form id="pass_form" action="<?php echo base_url();?>index.php/Auth/update_password"  method="post">
					<input type="hidden" name="user_type" value="<?= $this->session->userdata('user_type'); ?>">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group has-feedback">
								<label>Password: </label>
								<input type="password" placeholder="Enter Password" required class="form-control" name="password" >
									<div class="form-group float-right">
										<div class="help-tip">
											<p>Must include at least 8 chracters <br/>Must include at least 1 uppercase letter(A-Z) <br/>Must include at least 1 lowercase letter(a-z) <br/>Must include at least 1 numeric digit(0-9) <br/>Must include at least 1 special character(!@#$%^*)</p>
										</div>
									</div>
							</div>
						</div>
					</div>		
					<div class="row" >
						<div class="col-md-12">
							<div class="form-group has-feedback">
								<label>Confirm Password: </label>
								<input type="password" placeholder="Enter Confirm Password" required class="form-control" name="repassword" >
									<div class="form-group float-right">
										<div class="help-tip">
											<p>Must include at least 8 chracters <br/>Must include at least 1 uppercase letter(A-Z) <br/>Must include at least 1 lowercase letter(a-z) <br/>Must include at least 1 numeric digit(0-9) <br/>Must include at least 1 special character(!@#$%^*)</p>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit btn-submit" class="btn btn-primary">Update Password</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	console.log('Inside updated password popup');
	var passStatus  = "<?php echo $this->session->userdata('is_password_updated'); ?>";
	var userType    = "<?php echo $this->session->userdata('user_type'); ?>";
	console.log(passStatus);
	console.log(userType);
	if(passStatus == "" || passStatus == 0) {
		$("#modal_theme_password_update").modal('show');
	}

	$(document).ready(function() {
	    $('#pass_form').on('submit', function(e){
	    	console.log($(this).attr('action'));
	    	e.preventDefault();

	        $.ajax({
	            url: $(this).attr('action'),
	            type:'POST',
	            dataType: "json",
	            data:$(this).serialize(),
	            success: function(data) {
	            	console.log(data);
	                if($.isEmptyObject(data.error)){
	                	$(".print-error-msg").css('display','none');
	                	alert(data.success);
	                	location.reload();
	                }else{
						$(".print-error-msg").css('display','block');
	                	$(".print-error-msg").html(data.error);
	                }
	            }
	        });
	    }); 
	});
	
</script>