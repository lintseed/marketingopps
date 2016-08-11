/* Dashboard Widgets Suite - User Notes */

jQuery(document).ready(function($) {
	
	$('input[name="dws-notes-user[delete]"]').on('click', function() {
		
		if (confirm(dws_user_notes.confirm)) {
			return true;
		} else {
			return false;
		}
		
	});
	
	$('div.dws-notes-user-button-add a').toggle(function() {
		
		$(this).text(dws_user_notes.open);
		$('#dws-notes-user-add').slideDown(100);
		$('.dws-notes-user-button-add .fa').attr('class', 'fa fa-minus-circle');
		
	},function() {
		
		$(this).text(dws_user_notes.close);
		$('#dws-notes-user-add').slideUp(100);
		$('.dws-notes-user-button-add .fa').attr('class', 'fa fa-plus-circle');
		
	});
	
	$('div[data-key]').on('dblclick', function() {
		
		var id         = $(this).attr('data-key');
		var height     = $(this).innerHeight();
		var min_height = $(this).inlineStyle('min-height');
		var textarea   = $('textarea[data-key="'+ id +'"]');
		
		if (min_height) textarea.css('min-height', height);
		
		$(this).hide();
		textarea.show().css('display', 'block').focus().scrollTop(0).selectRange(0, 0);
		$(this).siblings('.dws-notes-user-buttons').show();
		
	});
	
	$('input[name="dws-notes-user[cancel]"]').on('click', function(e) {
		
		e.stopPropagation();
		
		var id = $(this).attr('data-key');
		
		$(this).closest('div.dws-notes-user-buttons').hide();
		$('textarea[data-key="'+ id +'"]').hide();
		$('div[data-key="'+ id +'"]').show();
		
		return false;
		
	});
	
	$('textarea[name="dws-notes-user[note]"]').each(function() {
		
		prepareString($(this));
		
	}).keyup(function() {
		
		prepareString($(this));
		
	});
	
	$('div.dws-notes-user-note').each(function() {
		
		var val = $(this).html();
		var br  = /(\r\n|\n\r|\r|\n)/g;
		
		$(this).html(val.replace(br, '<br />'));
		
	});
	
	$('div.dws-notes-user').each(function(index, value) {
		
		var id = 'textarea[data-key="'+ index +'"]';
		
		$(document).one('focus.textarea', id, function() {
			
			var savedValue = this.value;
			this.value = '';
			this.baseScrollHeight = this.scrollHeight;
			this.value = savedValue;
			
		}).on('input.textarea', id, function() {
			
			var minRows = this.getAttribute('data-rows') | 0, rows;
			this.rows = minRows;
			
			rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
			this.rows = minRows + rows;
			
		});
		
	});
	
});

function prepareString($this) {
	
	var val    = $this.val();
	var id     = $this.attr('data-key');
	var div    = 'div[data-key="'+ id +'"]';
	var br     = /(\r\n|\n\r|\r|\n)/g;
	var script = /<(java)?script(.*)?>(.*)?(<\/(java)?script>)?/gi;
	
	jQuery(div).html(val.replace(br, '<br />').replace(script, ''));
	
};

jQuery.fn.inlineStyle = function(prop) {
	
	return this.prop('style')[jQuery.camelCase(prop)];
	
};

jQuery.fn.selectRange = function(start, end) {
	
	if(!end) end = start;
	
	return this.each(function() {
		
		if (this.setSelectionRange) {
			
			this.focus();
			this.setSelectionRange(start, end);
			
		} else if (this.createTextRange) {
			
			var range = this.createTextRange();
			range.collapse(true);
			range.moveEnd('character', end);
			range.moveStart('character', start);
			range.select();
			
		}
		
	});
	
};
