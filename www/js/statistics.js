$(function() {
	$('#statistics-filter-form').submit(function() {
		$('select').each(function() {
			if (!$(this).val())
				$(this).attr('name', '');
		});
	});
});
