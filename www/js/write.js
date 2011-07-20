//validateEngine
$(document).ready(function(){
    // binds form submission and fields to the validation engine
    jQuery("#write").validationEngine();
});

//add name as signature
$(document).ready(function(){
  $("#write-name").change(function() {
    var current_text = $("#write-body").val();
    $("#write-body").val(current_text + $("#write-name").val() + "\n" + $("#write-location").val());
  });
});

//style button
$(document).ready(function(){
  $("#write-submit").button();
});
