( function( $ ) {
	$( document ).ready( function() {

		/* Define Event IDs */
		var iotParent = $('#in-category-27');
			var iot16 = $('#in-category-2');
			
		var teaParent = $('#in-category-28');
			var tea17 = $('#in-category-12');
		
		var naturalProducts = $('#in-category-29');	
			var ee16 = $('#in-category-11');
			var nbj17 = $('#in-category-31');
			
		var wasteParent = $('#in-category-36');	
			var waste17 = $('#in-category-37');
 
 		var industryParent = $('#in-category-39');	
 			var mtce17 = $('#in-category-38');	

 		/* Edit opps */
 		/* But first, hide them (possible from cmb2?) */
 		$('.types-levels').parents('div.postbox').hide();
 		
		if (iot16.is(':checked') || iotParent.is(':checked')) {
			$('#iot_metabox').show();
		} else if (ee16.is(':checked') || naturalProducts.is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if (tea17.is(':checked') || teaParent.is(':checked')) {
			$('#worldtea_metabox').show();
		} else if (nbj17.is(':checked') ) {
			$('#nbj_metabox').show();
		} else if (waste17.is(':checked') ) {
			$('#waste_metabox').show();
		} else if (mtce17.is(':checked') ) {
			$('#mtce_metabox').show();
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
			} else if (nbj17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#nbj_metabox').show();
			} else if (waste17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#waste_metabox').show();
			} else if (mtce17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mtce_metabox').show();
			} else {
				$('.types-levels').parents('div.postbox').hide();
			}
		});
	});
} )( jQuery );