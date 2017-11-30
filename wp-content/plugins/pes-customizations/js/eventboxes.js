( function( $ ) {
	$( document ).ready( function() {

		/*
 		** Define Event ID's
 		*/
		var iotParent = $('#in-category-27');
			var iot16 = $('#in-category-2');

		var teaParent = $('#in-category-28');
			var tea17 = $('#in-category-12');
			var tea18 = $('#in-category-60');

		var naturalProducts = $('#in-category-29');
			var ee17 = $('#in-category-11');
			var ee18 = $('#in-category-70');
			var ew17 = $('#in-category-40');
			var ew18 = $('#in-category-51');
			var ew19 = $('#in-category-81');
			var nbj17 = $('#in-category-31');
			var nbj18 = $('#in-category-72');
			var club17 = $('#in-category-42');
			var club18 = $('#in-category-75');
			var engredea17 = $('#in-category-41');
			var engredea18 = $('#in-category-53');

		var wasteParent = $('#in-category-36');
			var waste17 = $('#in-category-37');
			var waste18 = $('#in-category-68');

 		var industryParent = $('#in-category-39');
 			var mtce17 = $('#in-category-38');
 			var mtce18 = $('#in-category-73');
 			var sl = $('#in-category-63');

 		var ldiParent = $('#in-category-43');
 			var ldi17 = $('#in-category-44');

 		var pes = $('#in-category-45');

 		var itdev = $('#in-category-47');

 		var escabona = $('#in-category-48');

 		var mro = $('#in-category-54');

 		var cll = $('#in-category-57');

 		var tse = $('#in-category-50');
 			var mese18 = $('#in-category-80');

		var iwceParent = $('#in-category-61');
			var iwce18 = $('#in-category-62');

 		var dcw = $('#in-category-59');
 		
 		var mdtxParent = $('#in-category-76');
 			var mdtx18 = $('#in-category-77');

 		var monday = $('#in-category-79');

 		/*
 		** Edit opps
 		** But first, hide them
 		*/
 		$('.types-levels').parents('div.postbox').hide();

 		// iot
		if (iot16.is(':checked') || iotParent.is(':checked')) {
			$('#iot_metabox').show();
		// tea
		} else if (
			tea17.is(':checked') ||
			tea18.is(':checked') ||
			teaParent.is(':checked')
		) {
			$('#worldtea_metabox').show();
		// natural products
		} else if (ee17.is(':checked')) {
			$('#naturalproducts_metabox').show();
		} else if (ee18.is(':checked')) {
			$('#ee_metabox').show();
		} else if (ew17.is(':checked') || ew18.is(':checked')) {
			$('#ew_metabox').show();
		} else if (ew19.is(':checked') ) {
			$('#ew19_metabox').show();
		} else if (nbj17.is(':checked') ) {
			$('#nbj_metabox').show();
		} else if (nbj18.is(':checked') ) {
			$('#nbj18_metabox').show();
		} else if (club17.is(':checked') ) {
			$('#club_metabox').show();
		} else if (club18.is(':checked') ) {
			$('#club18_metabox').show();
		} else if (engredea17.is(':checked') || engredea18.is(':checked')) {
			$('#engredea_metabox').show();
		// waste
		} else if (waste17.is(':checked') || waste18.is(':checked')) {
			$('#waste_metabox').show();
		// industry week
		} else if (mtce17.is(':checked') ) {
			$('#mtce_metabox').show();
		// mtce18
		} else if (mtce18.is(':checked') ) {
			$('#mtce18_metabox').show();
		// safety leadership
		} else if (sl.is(':checked') ) {
			$('#sl_metabox').show();
		// ldi
		} else if (ldi17.is(':checked') ) {
			$('#ldi_metabox').show();
		// pes
		} else if (pes.is(':checked') ) {
			$('#pes_metabox').show();
		// it/dev
		} else if (itdev.is(':checked') ) {
			$('#itdev_metabox').show();
		// esca bona
		} else if (escabona.is(':checked') ) {
			$('#escabona_metabox').show();
		// mro
		} else if (mro.is(':checked') ) {
			$('#mro_metabox').show();
		// Contractor Leadership Live
		} else if (cll.is(':checked')) {
			$('#cll_metabox').show();
		// TSE
		} else if (tse.is(':checked')) {
			$('#tse_metabox').show();
		} else if (mese18.is(':checked')) {
			$('#mese18_metabox').show();
		// IWCE
		} else if (iwce18.is(':checked')) {
			$('#iwce_metabox').show();
		// DCW
		} else if (dcw.is(':checked')) {
			$('#dcw_metabox').show();
		// MDTX18
		} else if (mdtx18.is(':checked')) {
			$('#mdtx18_metabox').show();
		// MONDAY
		} else if (monday.is(':checked')) {
			$('#monday_metabox').show();
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
			} else if (
				tea17.is(':checked') ||
				tea18.is(':checked') ||
				teaParent.is(':checked')
			) {
				$('.types-levels').parents('div.postbox').hide();
				$('#worldtea_metabox').show();
			// natural products
			} else if (ee17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#naturalproducts_metabox').show();
			} else if (ee18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ee_metabox').show();
			} else if (ew17.is(':checked') || ew18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ew_metabox').show();
			} else if (ew19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ew19_metabox').show();
			} else if (nbj17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#nbj_metabox').show();
			} else if (nbj18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#nbj18_metabox').show();
			} else if (club17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#club_metabox').show();
			} else if (club18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#club18_metabox').show();
			} else if (engredea17.is(':checked') || engredea18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#engredea_metabox').show();
			// waste
			} else if (waste17.is(':checked') || waste18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#waste_metabox').show();
			// industry week
			} else if (mtce17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mtce_metabox').show();
			// mtce18
			} else if (mtce18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mtce18_metabox').show();
			// safety leadership
			} else if (sl.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#sl_metabox').show();
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
			// escabona
			} else if (escabona.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#escabona_metabox').show();
			// mro
			} else if (mro.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mro_metabox').show();
			// Contractor Leadership Live
			} else if (cll.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#cll_metabox').show();
			// TSE
			} else if (tse.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#tse_metabox').show();
			} else if (mese18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mese18_metabox').show();
			// DCW
			} else if (dcw.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#dcw_metabox').show();	
			// MDTX18
			} else if (mdtx18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mdtx18_metabox').show();
			// MONDAY	
			} else if (monday.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#monday_metabox').show();
			} else {
				$('.types-levels').parents('div.postbox').hide();
			}
		});
	});
} )( jQuery );
