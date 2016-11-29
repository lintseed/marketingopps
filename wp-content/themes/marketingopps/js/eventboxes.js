( function( $ ) {
	$( document ).ready( function() {
		
		/* 
 		** Define Event ID's
 		*/
		var iotParent = $('#in-category-27');
			var iot16 = $('#in-category-2');
			
		var teaParent = $('#in-category-28');
			var tea17 = $('#in-category-12');
		
		var naturalProducts = $('#in-category-29');	
			var ee17 = $('#in-category-11');
			var ew17 = $('#in-category-40');
			var nbj17 = $('#in-category-31');
			var club17 = $('#in-category-42');
			var engredea17 = $('#in-category-41');
			
		var wasteParent = $('#in-category-36');	
			var waste17 = $('#in-category-37');
 
 		var industryParent = $('#in-category-39');	
 			var mtce17 = $('#in-category-38');	
 			
 		var ldiParent = $('#in-category-43');	
 			var ldi17 = $('#in-category-44');	
 			
 		var pes = $('#in-category-45');			

 		var itdev = $('#in-category-47');			
 		
 		/* 
 		** Edit opps
 		** But first, hide them 
 		*/
 		$('.types-levels').parents('div.postbox').hide();
 		
 		// iot
		if (iot16.is(':checked') || iotParent.is(':checked')) {
			$('#iot_metabox').show();
		// tea
		} else if (tea17.is(':checked') || teaParent.is(':checked')) {
			$('#worldtea_metabox').show();
		// natural products
		} else if (ee17.is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if (ew17.is(':checked')) {
			$('#ew_metabox').show();
		} else if (nbj17.is(':checked') ) {
			$('#nbj_metabox').show();
		} else if (nbj17.is(':checked') ) {
			$('#nbj_metabox').show();
		} else if (club17.is(':checked') ) {
			$('#club_metabox').show();
			} else if (engredea17.is(':checked') ) {
			$('#engredea_metabox').show();
		// waste
		} else if (waste17.is(':checked') ) {
			$('#waste_metabox').show();
		// industry week
		} else if (mtce17.is(':checked') ) {
			$('#mtce_metabox').show();
		// ldi
		} else if (ldi17.is(':checked') ) {
			$('#ldi_metabox').show();
		// pes
		} else if (pes.is(':checked') ) {
			$('#pes_metabox').show();
		// it/dev
		} else if (itdev.is(':checked') ) {
			$('#itdev_metabox').show();
		} else {
			$('.types-levels').parents('div.postbox').hide();
		}
		
		/* 
 		** Display event meta boxes
 		*/
		$('#taxonomy-category :checkbox').change(function() {
			// iot
			if (iot16.is(':checked') || iotParent.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#iot_metabox').show();
			// tea
			} else if (tea17.is(':checked') || teaParent.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#worldtea_metabox').show();
			// natural products
			} else if (ee17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#naturalproducts_metabox').show();
			} else if (ew17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ew_metabox').show();
			} else if (nbj17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#nbj_metabox').show();
			} else if (club17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#club_metabox').show();
			} else if (engredea17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#engredea_metabox').show();
			// waste
			} else if (waste17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#waste_metabox').show();
			// industry week
			} else if (mtce17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mtce_metabox').show();
			// ldi
			} else if (ldi17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ldi_metabox').show();
			// pes
			} else if (pes.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#pes_metabox').show();
			// it/dev
			} else if (itdev.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#itdev_metabox').show();
			} else {
				$('.types-levels').parents('div.postbox').hide();
			}
		});
	});
} )( jQuery );