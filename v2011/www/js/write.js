//validateEngine
$(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#write").validationEngine();
});

//add name as signature
var signature_added = false;
$(document).ready(function(){
	$("#write-body").focus(function() {
		if (!signature_added) {
			var current_text = $("#write-body").val();
			$("#write-body").val(current_text + $("#write-name").val() + "\n" + $("#write-address").val() + "\n");
			signature_added = true;
			$("#write-body").caretTo(",\n\n", true);
		}
	});
});

//style button
$(document).ready(function(){
	$("#write-submit").button();
});

//toggle privacy explanations
$(document).ready(function(){
	$('#write-explanation-public').position({
		of: $("#write-radio-public"),
		my: "left top",
		at: "left bottom",
		offset: "0 4px"
	});
	$('#write-explanation-private').position({
		of: $("#write-radio-private"),
		my: "left top",
		at: "left bottom",
		offset: "0 4px"
	});
	$("#write-radio-public").focusin(function () {
		$('#write-explanation-public').show();
	});
	$("#write-radio-public").focusout(function () {
		$('#write-explanation-public').hide();
	});
	$("#write-radio-private").focusin(function () {
		$('#write-explanation-private').show();
	});
	$("#write-radio-private").focusout(function () {
		$('#write-explanation-private').hide();
	});
});
