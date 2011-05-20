/**
* js for search_results page
*
* warning: do not change names (or at least number of '-') of ids: search_results-
*/

$(document).ready(function() {
 initialize(lat,lng,zoom);
 //set address
 $('#search_results-geocode-address').val(address);
 codeAddress();
});

//define global variables
var geocoder;
var anticycle = 0;
var markersArray = [];

//initialize map
function initialize(lat,lng,zoom) {
	//geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat, lng);
	var myOptions = {
	  zoom: parseInt(zoom),
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};  
	map = new google.maps.Map(document.getElementById("search_results-map_canvas"), myOptions);
	codeAddress();
}

//geocode address
function codeAddress() {
  $('#search_results-message-debug').hide();
  $('#search_results-message').hide();

  var address = document.getElementById("search_results-geocode-address").value + ',' + parent_region; // e.g.:'+ 'Česká republika'
    
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { "address":address,"language":lang,"region":reg}, function(results, status) {
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
      results = show_messages(_("Try to improve your address, we have not been able to decipher this one."),"ERROR: Geocode was not successful for the following reason: " + status);
    }
  });
}

//process address from geocoding
function processAddress(results) {
  // set variables
  var found_regions_str;
  var regions = {"street_number":"long_name","route":"long_name","neighborhood":"long_name","sublocality":"long_name","locality":"short_name", "administrative_area_level_2":"long_name", "administrative_area_level_1":"long_name","country":"long_name"};
  
  //extract regions from address
  found_regions_str = extract_regions(results,regions);
  
  //check if address in given region
  var check1 = check_in_region(results[0].address_components, parent_region_type,"long_name",parent_region);
  if (!check1) {
    show_messages(sprintf(_("The address is not in region %s. Enter a new address, please")),"check1");
  } else {
  
    //check if address geocoded enough
    var conditions = new Array(new Array(region_check,"long_name"));
    var check2 = check_address_enough(results[0].address_components,conditions);
    if (!check2) {
      //try reverse geocoding
      //show_messages("check2","check2");	//debug only
      codeLatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
    } else {
      found_regions_str += '&formatted_address=' + results[0].formatted_address;
	  show_messages(_("Address found: ") + results[0].formatted_address,"");	
      ajaxForm('ajax/geocode4.ajax.php',found_regions_str,'#search_results-result');  
      anticycle = 0;
      //clear boxes + previous draggable (C+B)
      for (i=1;i<=3;i++) {
		if ($("#search_results-input-"+i).val() != '') {
		  var boxId = i;
		  var prevId =  $("#search_results-input-"+i).val()
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
function codeLatLng(lat,lng) {
  if (anticycle > 0) {
    show_messages(_("Try to improve your address, we have not been able to decipher this one."),"Anticycle check in reverse geocoding");
  } else {
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng,"language":lang,"region":reg}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //alert(dump(results));
        if (results[1]) {
        } else {
          show_messages(_("Try to improve your address, we have not been able to decipher this one."),"No results found for reverse geocoding");
        }
      } else {
        show_messages(_("Try to improve your address, we have not been able to decipher this one."),"Reverse Geocoder failed due to: " + status);
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
      frs += index + '=' + reg_val + '&';
	}
  });
  return frs;
}

function show_messages(str1,str2) {
    $('#search_results-message').hide();
    $('#search_results-message').html(str1);
    $('#search_results-message').fadeIn('slow');
    $('#search_results-message-debug').hide();
    $('#search_results-message-debug').html(str2);
    //$('#search_results-message-debug').fadeIn('slow'); //for debugging only!
    
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
			hoverClass: "ui-state-active",
			drop: function( event, ui ) {  //(B+A)
			    var thisIdAr = $(this).attr('id').split('-');
			    var thisId = thisIdAr[thisIdAr.length-1];  //id of box, from e.g. search_results-addressee-box-2
			    var selectedIdAr = ui.draggable.attr('id').split('-');
			    var selectedId = selectedIdAr[selectedIdAr.length-1]; //id of selected mp
			    var prevId = $("#search_results-input-"+thisId).val(); //id of previous mp in the box
				//toggle off previous mp		    
			    deselectAction(prevId);
			    //disable selected for next selection + get html + insert id into form			
				selectAction(selectedId,thisId);
			}
		});
});

//deselect on X	(B+C)
$(document).ready(function() {
  $(".mp-in-box-deselect").live('click',function() {
    //get boxId
    var boxIdAr = $(this).closest(".addressee-box").attr('id').split('-');
    var boxId = boxIdAr[boxIdAr.length-1];  //id of box, from e.g. search_results-addressee-box-2
    //get prevId
    var prevIdAr = $(this).closest(".mp-in-box").attr('id').split('-');
    var prevId = prevIdAr[prevIdAr.length-1];  //id of prev MP in box
    //B
    deselectAction(prevId);
    //C
    clearAction(boxId);
  });
});

//click on select
$(document).ready(function() {
  $(".mp-toggle-off").live('click',function() {
    //is any box free?
    var warn = true;
    for(i=1; i<=3; i++) {
      if ($("#search_results-input-"+i).val() == '') {
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
	$(".mp-toggle-"+prevId).removeClass('mp-toggle-on');
	$(".mp-toggle-"+prevId).addClass('mp-toggle-off');
	$(".mp-"+prevId).draggable({ disabled: false });
}

//action selecting current MP / A
//selectedId : mp_id of selected MP
//boxId: number of box
function selectAction(selectedId,boxId) {
    //disable selected for next selection
    $(".mp-toggle-"+selectedId).addClass('mp-toggle-on');
    $(".mp-toggle-"+selectedId).removeClass('mp-toggle-off');
    $(".mp-"+selectedId).draggable({ disabled: true });
    //get html
	ajaxMp('ajax/nj2_1mp.php','id='+selectedId,$("#search_results-addressee-box-"+boxId));
	//insert id into form			
	$("#search_results-input-"+boxId).val(selectedId);
}

//clear box / C
function clearAction(boxId) {
  $("#search_results-addressee-box-"+boxId).html('');
  $("#search_results-input-"+boxId).val('');
}

//show hide
$(document).ready(function() {
  $(".parliament .parliament-head").live('click',function() {
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

