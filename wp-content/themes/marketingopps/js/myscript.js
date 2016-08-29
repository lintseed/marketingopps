( function( $ ) {
	$( document ).ready( function() {

		/* Define Event IDs */
		var iotParent = $('#in-category-27');
			var iot16 = $('#in-category-2');
			
		var teaParent = $('#in-category-28');
			var tea17 = $('#in-category-12');
		
		var naturalProducts = $('#in-category-29');	
			var ee16 = $('#in-category-11');
 	
 		/* Edit opps */
 		/* But first, hide them (possible from cmb2?) */
 		$('.types-levels').parents('div.postbox').hide();
 		
		if (iot16.is(':checked') || iotParent.is(':checked')) {
			$('#iot_metabox').show();
		} else if (ee16.is(':checked') || naturalProducts.is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if (tea17.is(':checked') || teaParent.is(':checked')) {
			$('#worldtea_metabox').show();
		} else {
			$('.types-levels').parents('div.postbox').hide();
		}
		
		/* Create opp */
		$('#taxonomy-category :checkbox').change(function() {
			if (iot16.is(':checked') || iotParent.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#iot_metabox').show();
			} else if (ee16.is(':checked') || naturalProducts.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#naturalproducts_metabox').show();
			} else if (tea17.is(':checked') || teaParent.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#worldtea_metabox').show();
			} else {
				$('.types-levels').parents('div.postbox').hide();
			}
		});
	});
} )( jQuery );