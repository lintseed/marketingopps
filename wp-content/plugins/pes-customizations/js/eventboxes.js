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
			var ee19 = $('#in-category-98');
			var ew17 = $('#in-category-40');
			var ew18 = $('#in-category-51');
			var ew19 = $('#in-category-81');
			var nbj17 = $('#in-category-31');
			var nbj18 = $('#in-category-72');
			var nbj19 = $('#in-category-99');
			var club17 = $('#in-category-42');
			var club18 = $('#in-category-75');
			var engredea17 = $('#in-category-41');
			var engredea18 = $('#in-category-53');
			var ssw18 = $('#in-category-90');
			var sse19 = $('#in-category-102');

		var wasteParent = $('#in-category-36');
			var waste17 = $('#in-category-37');
			var waste18 = $('#in-category-68');

 		var industryParent = $('#in-category-39');
 			var mtce17 = $('#in-category-38');
 			var mtce18 = $('#in-category-73');
 			var sl = $('#in-category-63');
			var sl18 = $('#in-category-85');

 		var ldiParent = $('#in-category-43');
 			var ldi17 = $('#in-category-44');
			var ldi18 = $('#in-category-83');

 		var pes = $('#in-category-45');

 		var itdev = $('#in-category-47');

 		var escabona = $('#in-category-48');
			var escabona18 = $('#in-category-74');

 		var mro = $('#in-category-54');

 		var cll = $('#in-category-57');

 		var tse = $('#in-category-50');
 			var mese18 = $('#in-category-80');

		var iwceParent = $('#in-category-61');
			var iwce18 = $('#in-category-62');
			var iwce19 = $('#in-category-86');

 		var dcw = $('#in-category-59');

 		var mdtxParent = $('#in-category-76');
 			var mdtx18 = $('#in-category-77');
			var mdtx19 = $('#in-category-100');
 			var elecdesign = $('#in-category-84');

 		var monday = $('#in-category-79');

 		var uas = $('#in-category-82');
 		var uas19 = $('#in-category-101');
 		var uaw = $('#in-category-87');

 		var wfx = $('#in-category-94');

 		var vfeu = $('#in-category-97');



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
		} else if (ee19.is(':checked') ) {
			$('#ee19_metabox').show();
		} else if (ew17.is(':checked') || ew18.is(':checked')) {
			$('#ew_metabox').show();
		} else if (ew19.is(':checked') ) {
			$('#ew19_metabox').show();
		} else if (nbj17.is(':checked') ) {
			$('#nbj_metabox').show();
		} else if (nbj18.is(':checked') ) {
			$('#nbj18_metabox').show();
		} else if (nbj19.is(':checked') ) {
			$('#nbj19_metabox').show();
		} else if (club17.is(':checked') ) {
			$('#club_metabox').show();
		} else if (club18.is(':checked') ) {
			$('#club18_metabox').show();
		} else if (engredea17.is(':checked') || engredea18.is(':checked')) {
			$('#engredea_metabox').show();
		} else if ( ssw18.is(':checked') ) {
			$('#ssw18_metabox').show();
		} else if ( sse19.is(':checked') ) {
			$('#sse19_metabox').show();
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
		} else if (sl18.is(':checked') ) {
			$('#sl18_metabox').show();
		// ldi
		} else if (ldi17.is(':checked') || ldi18.is(':checked')) {
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
		// esca bona 2018
		} else if (escabona18.is(':checked') ) {
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
		// MESE
		} else if (mese18.is(':checked')) {
			$('#mese18_metabox').show();
		// IWCE
		} else if (iwce18.is(':checked')) {
			$('#iwce_metabox').show();
		} else if (iwce19.is(':checked')) {
			$('#iwce_metabox').show();
		// DCW
		} else if (dcw.is(':checked')) {
			$('#dcw_metabox').show();
		// MDTX18
		} else if (mdtx18.is(':checked')) {
			$('#mdtx18_metabox').show();
			// MDTX19
		} else if (mdtx19.is(':checked')) {
			$('#mdtx19_metabox').show();
		// Electronic Design Connect
		} else if (elecdesign.is(':checked')) {
			$('#elecdesign_metabox').show();
		// MONDAY
		} else if (monday.is(':checked')) {
			$('#monday_metabox').show();
		// UAS
		} else if (uas.is(':checked')) {
			$('#uas_metabox').show();
		} else if (uas19.is(':checked')) {
			$('#uas_metabox').show();
		// UAW
		} else if (uaw.is(':checked')) {
			$('#uaw_metabox').show();
		// WFX
		} else if (wfx.is(':checked')) {
			$('#wfx_metabox').show();
		// Vitafoods EU
		} else if (vfeu.is(':checked')) {
			$('#vfeu_metabox').show();
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
			} else if (ee19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ee19_metabox').show();
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
			} else if (nbj19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#nbj19_metabox').show();
			} else if (club17.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#club_metabox').show();
			} else if (club18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#club18_metabox').show();
			} else if (engredea17.is(':checked') || engredea18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#engredea_metabox').show();
			} else if ( ssw18.is(':checked') ) {
				$('.types-levels').parents('div.postbox').hide();
				$('#ssw18_metabox').show();
			} else if ( sse19.is(':checked') ) {
				$('.types-levels').parents('div.postbox').hide();
				$('#sse19_metabox').show();
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
			} else if (sl18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#sl18_metabox').show();
			// ldi
			} else if (ldi17.is(':checked') || ldi18.is(':checked')) {
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
			//MESE
			} else if (mese18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mese18_metabox').show();
			//IWCE
			} else if (iwce18.is(':checked') || iwce19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#iwce_metabox').show();
			// DCW
			} else if (dcw.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#dcw_metabox').show();
			// MDTX18
			} else if (mdtx18.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mdtx18_metabox').show();
				// MDTX19
			} else if (mdtx19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#mdtx19_metabox').show();
			// Electronic Design Connect
			} else if (elecdesign.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#elecdesign_metabox').show();
			// MONDAY
			} else if (monday.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#monday_metabox').show();
			// UAS
			} else if (uas.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#uas_metabox').show();
			} else if (uas19.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#uas_metabox').show();
			// UAW
			} else if (uaw.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#uaw_metabox').show();
			// WFX
			} else if (wfx.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#wfx_metabox').show();
			// VFEU
			} else if (vfeu.is(':checked')) {
				$('.types-levels').parents('div.postbox').hide();
				$('#vfeu_metabox').show();
			} else {
				$('.types-levels').parents('div.postbox').hide();
			}
		});
	});
} )( jQuery );
