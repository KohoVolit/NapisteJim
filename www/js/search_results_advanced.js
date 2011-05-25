/**
* js for search_results_advanced page
*/

//form validation
$(document).ready(function() {
  $("#search_results-input").val('');
});

$(document).ready(function() {
  $("#search_results-send").RSV({
    rules: [
      "required,mp,"+_("Choose at least one representative please"),
    ]
  });
});

//define global variables
var geocoder;
var anticycle = 0;
var markersArray = []; //markers on the map
var box = [];  //values in boxes
  box[1] = '';
  box[2] = '';
  box[3] = '';



//draggable - droppable
$(document).ready(function() {
		$( ".droppable" ).droppable({
			hoverClass: "ui-state-active",
			drop: function( event, ui ) { //(B+A) 				
			    var thisIdAr = $(this).attr('id').split('-');
			    var thisId = thisIdAr[thisIdAr.length-1];  //id of box, from e.g. search_results-addressee-box-2
			    var selectedIdAr = ui.draggable.attr('id').split('-');
			    var selectedId = selectedIdAr[selectedIdAr.length-1]; //id of selected mp
			    var prevId = box[thisId]; //id of previous mp in the box
				//toggle off previous mp		    
			    deselectAction(prevId);
			    //disable selected for next selection + get html + insert id into form			
				selectAction(selectedId,thisId);
			}
		});
		$( ".draggable" ).draggable({
		    appendTo: "body",
			helper: "clone"
		});
});

//deselect on X	(B+C)
$(document).ready(function() {
  $(".box-x").live('click',function() {
    //get boxId
    var boxIdAr = $(this).closest(".addressee-box").attr('id').split('-');
    var boxId = boxIdAr[boxIdAr.length-1];  //id of box, from e.g. search_results-addressee-box-2
    //get prevId
    var prevId = box[boxId];  //id of prev MP in box
    //B
    deselectAction(prevId);
    //C
    clearAction(boxId);
  });
});

//click on select / A
$(document).ready(function() {
  $(".mp-clicked-off").live('click',function() {
    //is any box free?
    var warn = true;
    for(i=1; i<=3; i++) {
      if (box[i] == '') {
        var boxId = i;
        var warn = false;
        i=3;
      }
    }
    if (warn) {
		alert(_('Lze vybrat max. 3 adresáty. Pro přidání dalšího adresáta nejprve jiného, prosím, odeberte. Nebo použíjte přetažení'));
    } else {
      //get selectedId
      var selectedIdAr = $(this).attr('id').split('-');
      var selectedId = selectedIdAr[selectedIdAr.length-1];
      //add selectedId into boxId (A)
      selectAction(selectedId,boxId);
    }
    
  });
});	

//ajax call with mp_id
function ajaxMp(page,data,result_div){
	$.ajax({
	  url: page,
	  data: data,
	  success: function(data) {
		$(result_div).html(data);
	  }
	});	  
}

//action deselecting previous MP / B
//prevId : mp_id of prev. MP
function deselectAction(prevId) {
	//we have to deal with jQuery bug, cannot select 'cz/psp/97'
	var shortPrevIdAr = prevId.split('/');
    var shortPrevId = shortPrevIdAr[shortPrevIdAr.length-1];
    //deselect
	$(".mp-clicked-"+shortPrevId).addClass('mp-toggle-off mp-clicked-off');
	$(".mp-clicked-"+shortPrevId).removeClass('mp-toggle-on mp-clicked-on');
	$(".mp-"+shortPrevId).draggable({ disabled: false });
}

//action selecting current MP / A
//selectedId : mp_id of selected MP
//boxId: number of box
function selectAction(selectedId,boxId) {
	//we have to deal with jQuery bug, cannot select 'cz/psp/97'
	var shortSelectedIdAr = selectedId.split('/');
    var shortSelectedId = shortSelectedIdAr[shortSelectedIdAr.length-1];
    //disable selected for next selection
    $(".mp-clicked-"+shortSelectedId).addClass('mp-toggle-on mp-clicked-on');
    $(".mp-clicked-"+shortSelectedId).removeClass('mp-toggle-off mp-clicked-off');
    $(".mp-"+shortSelectedId).draggable({ disabled: true });
    //get html
	ajaxMp('ajax/id2mp.search_results.php','id='+selectedId,$("#search_results-addressee-box-"+boxId));
	//insert id into form			
	box[boxId] = selectedId;
	$("#search_results-input").val(setFormValue(box));
}

//clear box / C
function clearAction(boxId) {
  $("#search_results-addressee-box-"+boxId).html('');
  box[boxId] = '';
  $("#search_results-input").val(setFormValue(box));
}

//show hide
$(document).ready(function() {
  $(".parliament-head").live('click',function() {
  $(this).next().toggle('fast');
		return false;
  });
});


//function to set value of the final form
function setFormValue(box) {
  var out = '';
  for (i=1;i<=3;i++) {
    if (box[i] != '') {
      out = out + box[i] + '|';
    }
  }
  if (out != '')
    out = out.slice(0,-1);
  return out;
}

//ajax call with decoded address
function ajaxForm(page,data,result_div){
	$.ajax({
	  url: page,
	  data: data,
	  success: function(data) {
		$(result_div).hide();
		$(result_div).html(data);
		$(result_div).fadeIn('slow');
		//alert('ajax: success'+ data);
		$( ".draggable" ).draggable({
			appendTo: "body",
			helper: "clone"
		});
	  }
	});
}
