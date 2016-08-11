( function( $ ) {
 
	$( document ).ready( function() {
		$('#taxonomy-category :checkbox').change(function() {
			if ($('#in-category-2').is(':checked') || $('#in-category-27').is(':checked')) {
				$('#iot_metabox').show();
			} else {
				$('#iot_metabox').hide();
			}
		});
	});

} )( jQuery );