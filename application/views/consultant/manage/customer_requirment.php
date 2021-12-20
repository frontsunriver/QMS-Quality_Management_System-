<!-- Primary modal -->
          <div id="customer_requirments" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i> CUSTOMER REQUIREMENT: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newcustomer_requirment">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="customer_requirmenterr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_customer_requirment();" class="btn btn-primary">ADD</a>
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
                            <tbody id="customer_requirmentlist">
                              
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
	function add_customer_requirment() { 
	var newcustomer_requirment = $('#newcustomer_requirment').val(); 
	if (newcustomer_requirment.length==0) {
     $('#customer_requirmenterr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_customer_requirment",
                    data:{'name' : newcustomer_requirment},
                    success: function(data) {
    	                $('#customer_requirment').html(data);
	                    $('#newcustomer_requirment').val('');
						callcustomer_requirment();
						callcustomer_requirment1();

					}
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_customer_requirment",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#customer_requirment').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_customer_requirment_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#customer_requirmentlist').html(data);
                    }
                  });
  });

  function callcustomer_requirment(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_customer_requirment_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#customer_requirmentlist').html(data);
                    }
                  });

  	          
  }
  function deletecustomer_requirment(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_customer_requirment",
                    data:{'id' :val},
                    success: function(data) {
						callcustomer_requirment();
						callcustomer_requirment1();

                    }
                  });
  }

  function callcustomer_requirment1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_customer_requirment",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#customer_requirment').html(data);
                    }
                  });
  }
</script>
