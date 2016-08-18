( function( $ ) {
 
	$( document ).ready( function() {
		if ($('#in-category-2').is(':checked') || $('#in-category-27').is(':checked')) {
			$('#iot_metabox').show();
		} else if ($('#in-category-11').is(':checked') || $('#in-category-29').is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if ($('#in-category-12').is(':checked') || $('#in-category-28').is(':checked')) {
			$('#worldtea_metabox').show();
		} else {
			$('#iot_metabox').hide();
			$('#naturalproducts_metabox').hide();
			$('#worldtea_metabox').hide();
		}
			
		$('#taxonomy-category :checkbox').change(function() {
			if ($('#in-category-2').is(':checked') || $('#in-category-27').is(':checked')) {
				$('#naturalproducts_metabox').hide();
				$('#worldtea_metabox').hide();
				$('#iot_metabox').show();
			} else if ($('#in-category-11').is(':checked') || $('#in-category-29').is(':checked')) {
				$('#iot_metabox').hide();
				$('#worldtea_metabox').hide();
				$('#naturalproducts_metabox').show();
			} else if ($('#in-category-12').is(':checked') || $('#in-category-28').is(':checked')) {
				$('#iot_metabox').hide();
				$('#naturalproducts_metabox').hide();
				$('#worldtea_metabox').show();
			} else {
				$('#iot_metabox').hide();
				$('#naturalproducts_metabox').hide();
				$('#worldtea_metabox').hide();
			}
		});
	});

} )( jQuery );

