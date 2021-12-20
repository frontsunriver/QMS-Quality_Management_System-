<!-- Primary modal -->
          <div id="products" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i>PRODUCT: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newproduct">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="producterr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_product();" class="btn btn-primary">ADD</a>
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
                            <tbody id="productlist">
                              
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
	function add_product() { 
	var newproduct = $('#newproduct').val(); 
	if (newproduct.length==0) {
     $('#producterr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_product",
                    data:{'name' : newproduct},
                    success: function(data) {
                    	
                    $('#product').html(data);
                    $('#newproduct').val('');
						callproduct();
						callproduct1();

					}
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_product",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#product').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_product_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#productlist').html(data);
                    }
                  });
  });

  function callproduct(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_product_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#productlist').html(data);
                    }
                  });

  	          
  }
  function deleteproduct(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_product",
                    data:{'id' :val},
                    success: function(data) {
						callproduct();
						callproduct1();


                    }
                  });
  }

  function callproduct1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_product",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#product').html(data);
                    }
                  });
  }
</script>
