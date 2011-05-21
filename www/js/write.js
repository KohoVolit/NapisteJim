jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    jQuery("#write").validationEngine();
});
jQuery(document).ready(function(){
  $("#write-name").change(function() {
    var current_text = $("#write-body").val();
    $("#write-body").val(current_text + $("#write-name").val());
  });
});
