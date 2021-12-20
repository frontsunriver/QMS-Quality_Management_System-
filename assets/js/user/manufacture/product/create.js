var oTable, pIndex;

$(function(){
	// Success
	$(".control-success").uniform({
		radioClass: 'choice',
		wrapperClass: 'border-success-600 text-success-800'
	});

	// Single file
	$("#product_img").dropzone({
		url: base_url + 'manufacture/product/upload',
		paramName: "file", // The name that will be used to transfer the file
		maxFiles: 1,
		dictDefaultMessage: 'Drop file to upload or CLICK',
		autoProcessQueue: false,
		init: function() {
			this.on('addedfile', function(file){
				if (this.fileTracker) {
					this.removeFile(this.fileTracker);
				}
				this.fileTracker = file;
			});
		},
		fallback: function() {
		}
	});

	$("#create_form").validate({
		ignore: 'input[type=hidden]',
		errorClass: 'validation-error-label',
		successClass: 'validation-valid-label',
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		},
		unhighlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		},
		validClass: "validation-valid-label",
		rules: {
			'create[category_id]': { required: true }
			, 'create[name]': { required: true }
			, 'create[reference]': { required: true }
			, 'create[barcode]': { required: true }
			, 'create[version]': { required: true }
			, 'create[sales_price]': { required: true }
			, 'create[cusomter_tax]': { required: true }
			, 'create[cost]': { required: true }
		},
		success: function(label) {
			label.addClass("validation-valid-label").text("Success.");
		}
	});

	$('.file-upload').on('change', function(){
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.upload-file').css('background-image', 'url(' + e.target.result + ')');
			}
			reader.readAsDataURL(this.files[0]);
		}
		$('.upload-file').children().hide();
	});

	$('.upload-file').on('click', function() {
		$('.file-upload').click();
	});

	if (image != '') {
		$('.upload-file').children().hide();
		$('.upload-file').css('background-image', 'url(' + base_url + 'uploads/product/' + image + ')');
	}

	//datatable
	$.extend( $.fn.dataTable.defaults, {
		autoWidth: false,
		dom: '<"datatable-scroll"t>',
		drawCallback: function () {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
		},
		preDrawCallback: function() {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
		}
	});

	oTable = $('#attr_tbl').DataTable({
		columnDefs: [{
			orderable: false,
			targets: [0, 1, 2]
		}]
	});

	pIndex = oTable.data().length;

	$('button#add_btn').on('click', function(e){
		var row = new Array();

		row[0] = '<input type="text" class="form-control form-control-sm" name="attr[' + pIndex + '][name]" />';
		row[1] = '<input data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control form-control-sm" name="attr[' + pIndex + '][value]" />';
		row[2] = '<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteItem(this);"></i></li></ul>'

		oTable.row.add(row);
		oTable.draw();

		$("input[data-role=tagsinput]").tagsinput();

		pIndex ++;
	});
});

function onCreate() {
	$("#create_form").submit();
}

function onBack() {
	history.back();
}

function onDeleteItem(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
}