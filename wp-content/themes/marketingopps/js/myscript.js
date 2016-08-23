( function( $ ) {
	$( document ).ready( function() {

		/* Define Event ID's */
		var iotParent = $('#in-category-27');
			var iot16 = $('#in-category-2');
			
		var teaParent = $('#in-category-28');
			var tea17 = $('#in-category-12');
		
		var naturalProducts = $('#in-category-29');	
			var ee16 = $('#in-category-11');
 	
 		/* Edit opps */
 		$('#iot_metabox').hide();
		$('#naturalproducts_metabox').hide();
		$('#worldtea_metabox').hide();
 		
		if (iot16.is(':checked') || iotParent.is(':checked')) {
			$('#iot_metabox').show();
		} else if (ee16.is(':checked') || naturalProducts.is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if (tea17.is(':checked') || teaParent.is(':checked')) {
			$('#worldtea_metabox').show();
		} else {
			$('#iot_metabox').hide();
			$('#naturalproducts_metabox').hide();
			$('#worldtea_metabox').hide();
		}
		
		/* Create opp */
		$('#taxonomy-category :checkbox').change(function() {
			if (iot16.is(':checked') || iotParent.is(':checked')) {
			
				/* find a way to add a class to these boxes and hide all, this is redundant as hell */
				$('#naturalproducts_metabox').hide();
				$('#worldtea_metabox').hide();
				
				$('#iot_metabox').show();
				
			} else if (ee16.is(':checked') || naturalProducts.is(':checked')) {
			
				$('#iot_metabox').hide();
				$('#worldtea_metabox').hide();
				
				$('#naturalproducts_metabox').show();
				
			} else if (tea17.is(':checked') || teaParent.is(':checked')) {
			
				$('#iot_metabox').hide();
				$('#naturalproducts_metabox').hide();
				
				$('#worldtea_metabox').show();
				
			} else {
				
				/* find a way to add a class to these boxes and hide all, this is redundant as hell */
				$('#iot_metabox').hide();
				$('#naturalproducts_metabox').hide();
				$('#worldtea_metabox').hide();
				
			}
		});
	});
} )( jQuery );