$(function(){
	var speedA = $('select#advanced_search-select-parliament').selectmenu({
	    width: 420,
	    style:'dropdown',
		select: function(event, options) {
			$.ajax({
				data: "parliament_code=" + $('#advanced_search-select-parliament').val(),
				type: "GET",
				// you need a serversite script which checks the username
				url: "ajax/parliament2groups.php?",
				success: function(value) {
					// add the returned HTML (the new select)
					 $("#advanced_search-selects").html(value).find("#new").children("select").selectmenu({width:420,maxHeight:400,maxWidth:420,style:'dropdown'});
					 $("#advanced_search-submit").button();
					 $("#advanced_search-export").show();
				}
			});
		}
	});

});
$(function(){
  $("#advanced_search-export").button();
  $("#advanced_search-export").hide();
  $("#advanced_search-export").click(function() {
    $("#advanced_search-hidden-value").val('export');
    var data = $('#advanced_search-form').serialize();
    $.ajax({
      data: data,
      url: "ajax/groups2emails.php",
      success: function (value) {
        $("#advanced_search-export-result").html(value);
        $("#advanced_search-hidden-value").val('page');
      }
    });
  });
});

function sendForm() {
  var str = "";
  $( ".advanced_search-select-2" ).each( function() {
     if ( $(this).val() != 0) {
       str += $( this ).val() + "|";
     }
  });
  if (str.length > 0) str = str.substring(0, str.length-1);
  $("#advanced_search-hidden-groups").val(str);
  $("#advanced_search-hidden-constituency").val($("#constituency").val());
  $("#advanced_search-hidden-parliament").val($("#advanced_search-select-parliament").val());
  $("#advanced_search-hidden").submit();
}

