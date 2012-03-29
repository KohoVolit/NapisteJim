/**
* js for choose page
*/

//form validation
$(document).ready(function() {
  $("#choose-input").val('');
});

$(document).ready(function() {
  $("#choose-send").RSV({
    rules: [
      "required,mp," + _("Choose at least one representative, please.").replace(/,/g, '\\,'),
    ]
  });
});
//active ui buttons
$(document).ready(function() {
  $("#choose-submit-mps").button();
  $("#choose-submit-geocode").button();
});

//geocoding + form
$(document).ready(function() {
	initialize(map_center_lat, map_center_lng, map_zoom);
	//set address
	$('#choose-geocode-address').val(address);
	codeAddress();
});

//define global variables
var geocoder;
var anticycle = 0;
var markersArray = []; //markers on the map
var box = [];  //values in boxes
  box[1] = '';
  box[2] = '';
  box[3] = '';

//initialize map
function initialize(lat, lng, zoom) {
	//geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat, lng);
	var myOptions = {
	  zoom: parseInt(zoom),
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("choose-map_canvas"), myOptions);
	codeAddress();
}


//geocode address
function codeAddress() {
  $('#choose-message-debug').hide();
  $('#choose-message').hide();

  var address = document.getElementById("choose-geocode-address").value + ', ' + country_name;

    geocoder = new google.maps.Geocoder();
    geocoder.geocode({"address": address}, function(results, status) {
	if (status == google.maps.GeocoderStatus.OK) {
	  //clear previous marker
	  clearOverlays();
	  //set map and new marker
	  map.setCenter(results[0].geometry.location);
	    map.fitBounds(results[0].geometry.viewport);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        markersArray.push(marker); //remember marker
      //postprocess
      processAddress(results);
	} else { //stop whole process
      results = show_messages(_("Be more specific entering your address, please. This one has not been recognized."), "ERROR: Geocoding has not been successful for the following reason: " + status, 'error');
    }
  });
}

//process address from geocoding
function processAddress(results) {
  // set variables
  var found_regions_str;
  var regions = {"street_number":"long_name", "route":"long_name", "neighborhood":"long_name", "sublocality":"long_name", "locality":"short_name", "administrative_area_level_2":"long_name", "administrative_area_level_1":"long_name", "country":"long_name"};

  //extract regions from address
  found_regions_str = extract_regions(results, regions);

  //check if address in given region
  var check1 = check_in_region(results[0].address_components, "country", "long_name", country_name);
  if (!check1) {
    show_messages(sprintf(_("The address is not in country %s. Enter a new address, please."), country_name), "check1", 'error');
  } else {

    //check if address geocoded enough
    var conditions = new Array(new Array(required_address_level, "long_name"));
    var check2 = check_address_enough(results[0].address_components, conditions);
    if (!check2) {
      //try reverse geocoding
      //show_messages("check2","check2",'');	//debug only
      codeLatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
    } else {
      found_regions_str += '&formatted_address=' + encodeURIComponent(results[0].formatted_address);
      found_regions_str += '&latitude=' + results[0].geometry.location.lat();
      found_regions_str += '&longitude=' + results[0].geometry.location.lng();
	  show_messages(_("Address found:") + " <strong>" + results[0].formatted_address + "</strong>", "", 'alert');
      ajaxForm('ajax/address_representatives.php', found_regions_str, '#choose-result');
      anticycle = 0;
      //clear boxes + previous draggable (C+B)
      for (i=1;i<=3;i++) {
		if (box[i] != '') {
		  var boxId = i;
		  var prevId =  box[i];
		  //B
		  deselectAction(prevId);
		  //C
		  clearAction(boxId);
		}
      }
    }
  }

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

//reverse geocoding
function codeLatLng(lat, lng) {
  if (anticycle > 0) {
    show_messages(_("Be more specific entering your address, please. This one has not been recognized."), "Anticycle check in reverse geocoding", 'error');
  } else {
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //alert(dump(results));
        if (results[1]) {
        } else {
          show_messages(_("Be more specific entering your address, please. This one has not been recognized."), "No results found for reverse geocoding", 'error');
        }
      } else {
        show_messages(_("Be more specific entering your address, please. This one has not been recognized."), "Reverse Geocoder failed due to: " + status, 'error');
      }
      anticycle++;
      processAddress(results);
    });
  }
}

//check if given address is good enough (e.g., contains important region names)
function check_address_enough(address_components,conditions) {
  var out = true;
  $.each(conditions, function(index, value) {
    if (typeof g_find_type_in_results(address_components, value[0], value[1]) === 'undefined') out = false;
  });
  return out;
}

//check if given address is in the correct region
function check_in_region(address_components,type,name_,value) {
  if (g_find_type_in_results(address_components,type,name_) == value) {
    return true;
  } else {
    return false;
  }
}

//extracts regions from 'regions' object; helper function
function extract_regions(results,regions) {
  var frs = '';
  $.each(regions, function(index, value) {
	var reg_val = g_find_type_in_results(results[0].address_components, index,value);
	if (!(typeof reg_val === 'undefined')) {
      frs += index + '=' + encodeURIComponent(reg_val) + '&';
	}
  });
  return frs;
}

//finds value for

function show_messages(str1,str2,type) {
    $('#choose-message').hide();
    //$('#choose-message').html(str1);
    if (type == 'error') {
       $('#choose-message').writeError(str1);
    } else {
      $('#choose-message').writeAlert(str1);
    }
    $('#choose-message').fadeIn('slow');
    $('#choose-message-debug').hide();
    $('#choose-message-debug').html(str2);
    //$('#choose-message-debug').fadeIn('slow'); //for debugging only!

}

//finds given type in address; helper function
function g_find_type_in_results(ar,type,name_) {
  var out;
  for(var item in ar) {
    for(var subitem in ar[item].types) {
      if (ar[item].types[subitem] == type) {
        out = ar[item][name_];
      }
    }
  }
  return out;
}

//draggable - droppable
$(document).ready(function() {
		$( ".droppable" ).droppable({
			hoverClass: "ui-state-active-border",
			drop: function( event, ui ) {  //(B+A)
			    var thisIdAr = $(this).attr('id').split('-');
			    var thisId = thisIdAr[thisIdAr.length-1];  //id of box, from e.g. choose-addressee-box-2
			    var selectedIdAr = ui.draggable.attr('id').split('-');
			    var selectedId = selectedIdAr[selectedIdAr.length-1]; //id of selected mp
			    var prevId = box[thisId]; //id of previous mp in the box
				//toggle off previous mp
			    deselectAction(prevId);
			    //disable selected for next selection + get html + insert id into form
				selectAction(selectedId,thisId);
			}
		});
});

//deselect on X	(B+C)
$(document).ready(function() {
  $(".box-x").live('click',function() {
    //get boxId
    var boxIdAr = $(this).closest(".addressee-box").attr('id').split('-');
    var boxId = boxIdAr[boxIdAr.length-1];  //id of box, from e.g. choose-addressee-box-2
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
		alert(_('Three representatives can be chosen at most. Remove one of the chosen representatives first to add another one or use drag and drop, please.'));
    } else {
      //get selectedId
      var selectedIdAr = $(this).attr('id').split('_');
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
	$(".mp-clicked-"+shortPrevId).addClass('mp-clicked-off');
	$(".mp-clicked-"+shortPrevId).removeClass('ui-state-highlight mp-clicked-on');
	$(".mp-"+shortPrevId).draggable({ disabled: false });
	$(".mp-clicked-"+shortPrevId).draggable({ disabled: false });
}

//action selecting current MP / A
//selectedId : mp_id of selected MP
//boxId: number of box
function selectAction(selectedId,boxId) {
	//we have to deal with jQuery bug, cannot select 'cz/psp/97'
	var shortSelectedIdAr = selectedId.split('/');
    var shortSelectedId = shortSelectedIdAr[shortSelectedIdAr.length-1];
    //disable selected for next selection
    $(".mp-clicked-"+shortSelectedId).addClass('ui-state-highlight  mp-clicked-on');
    $(".mp-clicked-"+shortSelectedId).removeClass('mp-clicked-off');
    $(".mp-"+shortSelectedId).draggable({ disabled: true });
    $(".mp-clicked-"+shortSelectedId).draggable({ disabled: true });
    //get html
	ajaxMp('ajax/mp_details.php', 'id=' + selectedId, $("#choose-addressee-box-" + boxId));
	//insert id into form
	box[boxId] = selectedId;
	$("#choose-input").val(setFormValue(box));
}

//clear box / C
function clearAction(boxId) {
  $("#choose-addressee-box-"+boxId).html('');
  box[boxId] = '';
  $("#choose-input").val(setFormValue(box));
}

//show hide
$(document).ready(function() {
  $(".parliament-head").live('click',function() {
    $(this).find(".ui-icon").toggleClass("ui-icon-triangle-1-s");
    $(this).find(".ui-icon").toggleClass("ui-icon-triangle-1-e");
    $(this).find("a").toggleClass("ui-state-active");
    $(this).find("a").toggleClass("ui-state-default");
    //$(this).toggleClass("ui-state-active");
    $(this).next().toggle('fast');
		return false;
  });
});

//function to clear markers
function clearOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
  }
}

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


