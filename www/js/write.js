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
