<!-- Primary modal -->
          <div id="policys" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i> POLICY/PROCEDURE/RECORDS:: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newpolicy">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="policyerr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_policy();" class="btn btn-primary">ADD</a>
                       </div>
                     </div>
                  <div class="row">
                       <div class="col-md-12">
                         <table class="table">
                           <thead>
                            <tr>
                              <th>VALUE</th>
                            <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody id="policylist">
                              
                            </tbody>
                         </table>
                       </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
                  </form>
              </div>
            </div>
          </div>
<!-- /primary modal -->


<script type="text/javascript">
	function add_policy() { 
	var newpolicy = $('#newpolicy').val(); 
	if (newpolicy.length==0) {
     $('#policyerr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_policy",
                    data:{'name' : newpolicy},
                    success: function(data) {
                    	
    	                $('#policy').html(data);
	                    $('#newpolicy').val('');
						callpolicy();
						callpolicy1();

					}
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_policy",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#policy').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_policy_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#policylist').html(data);
                    }
                  });
  });

  function callpolicy(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_policy_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#policylist').html(data);
                    }
                  });

  	          
  }
  function deletepolicy(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_policy",
                    data:{'id' :val},
                    success: function(data) {
						callpolicy();
						callpolicy1();

                    }
                  });
  }

  function callpolicy1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_policy",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#policy').html(data);
                    }
                  });
  }
</script>
