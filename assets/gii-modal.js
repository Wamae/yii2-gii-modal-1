$(function(){
	$(document).on('click', '.show-modal',  function(){
		var elm = $(this),
        target = elm.attr('data-target'),
        ajax_body = elm.attr('value'),
		header = elm.attr('data-header')||'';
		
		var h4 = $(target).find('.modal-header').find('h4');
		if(h4.length === 0)
		    $('<h4>'+header+'</h4>').appendTo($(target).find('.modal-header'));
		else
			h4.text(header);
		
		$(target).modal('show')
        	.find('.modal-body')
        	.load(ajax_body);
	});
	
	 $('body').on('hidden.bs.modal', '.modal', function () {
		 $(this).find('.modal-body').empty();
	 });
});