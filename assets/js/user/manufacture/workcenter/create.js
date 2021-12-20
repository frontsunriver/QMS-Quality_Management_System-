$(function(){
	// Success
	$(".switch").bootstrapSwitch();

	// Time picker
    $('#time_for_cycle').AnyTime_picker({
        format: "%H:%i"
    });

    $('#time_before_prod').AnyTime_picker({
        format: "%H:%i"
    });

    $('#time_after_prod').AnyTime_picker({
        format: "%H:%i"
    });

	$('#create_form').validate({
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
			'create[name]': { required: true }
			, 'create[code]': { required: true }
			, 'create[efficiency_factor]': { required: true }
			, 'create[capacity_per_cycle]': { required: true }
			, 'create[time_for_cycle]': { required: true }
			, 'create[time_before_prod]': { required: true }
			, 'create[time_after_prod]': { required: true }
			, 'create[cost_per_hour]': { required: true }
			, 'create[cost_per_cycle]': { required: true }
		},
		success: function(label) {
			label.addClass("validation-valid-label").text("Success.");
		}
	});
});

function onSave() {
	$("#create_form").submit();
}