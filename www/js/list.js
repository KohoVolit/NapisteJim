$(function() {
	$( "#recipient" ).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "http://" + nj_host + "/ajax/mp_name.php",
				dataType: "jsonp",
				data: {
					terms: request.term
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							value: item.name + (item.disambiguation ? ', ' + item.disambiguation : ''),
							name: item.name,
							disambiguation: item.disambiguation
						}
					}));
				}
			});
		},
		minLength: 3,
		delay: 150,
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
	})
	.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.name + (item.disambiguation ? '<span class="disambiguation">, ' + item.disambiguation + "</span>" : '') + "</a>" )
			.appendTo( ul );
	};
});

$(function() {
	$.datepicker.setDefaults( $.datepicker.regional[ lang ] );
	$( "#since" ).datepicker();
	$( "#until" ).datepicker();
});

$(function() {
	$('#list-filter-form').submit(function() {
		$('input[name],select').each(function() {
			if (!$(this).val())
				$(this).attr('name', '');
		});
	});
});
