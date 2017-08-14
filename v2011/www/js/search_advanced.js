$(function(){
	var speedA = $('select#search_advanced-select-parliament').selectmenu({
	    width: 420,
	    style:'dropdown',
		select: function(event, options) {
			$.ajax({
				data: "parliament_code=" + $('#search_advanced-select-parliament').val() + "&lang=" + lang,
				type: "GET",
				// you need a serversite script which checks the username
				url: "ajax/parliament_groups.php?",
				success: function(value) {
					// add the returned HTML (the new select)
					 $("#search_advanced-selects").html(value).find("#new").children("select").selectmenu({width:420,maxHeight:400,maxWidth:420,style:'dropdown'});
					 $("#search_advanced-submit").button();
					 $("#search_advanced-export").show();
				}
			});
		}
	});

});
$(function(){
  $("#search_advanced-export").button();
  $("#search_advanced-export").hide();
  $("#search_advanced-export").click(function() {
    $("#search_advanced-hidden-value").val('export');
    var data = $('#search_advanced-form').serialize();
    $.ajax({
      data: data,
      url: "ajax/members_emails.php",
      success: function (value) {
        $("#search_advanced-export-result").html(value);
        $("#search_advanced-hidden-value").val('page');
      }
    });
  });
});

function sendForm() {
  var str = "";
  $(".search_advanced-select-2").each( function() {
     if ( $(this).val() != 0) {
       str += $( this ).val() + "|";
     }
  });
  if (str.length > 0) str = str.substring(0, str.length-1);
  if (str == '' && $("#constituency").val() == 0) return;
  $("#search_advanced-hidden-groups").val(str);
  $("#search_advanced-hidden-constituency").val($("#constituency").val());
  $("#search_advanced-hidden-parliament").val($("#search_advanced-select-parliament").val());
  $("#search_advanced-hidden").submit();
}

