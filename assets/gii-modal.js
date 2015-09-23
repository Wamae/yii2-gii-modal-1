$(function(){
    $(document).on('click', '.show-modal',  function(){
        var self = $(this),
        	target = $(self.attr('data-target')),
            ajax_url = self.attr('data-url') || self.attr('href'),
            header = elm.attr('data-header')||'';
		var h4 = target.find('.modal-header').find('h4');
		if (h4.length === 0) {
		    $('<h4>'+header+'</h4>').appendTo(target.find('.modal-header'));
		} else {
			h4.text(header);
		}
        if (ajax_url) {
        	target.modal('show').find('.modal-body').empty().load(ajax_url);
        }
    });
	$('body').on('beforeSubmit', 'form[data-ajax]', function () {
		var formData = new FormData(this);
		var form = $(this);
		// submit form
		$.ajax({
			url: form.attr('action'),
			type: 'post',
			enctype: 'multipart/form-data',
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			data: formData,
			success: function (response) {
				form.closest('.modal-body').html(response);
			}
		});
		return false;
	});
	$('body').on('click', 'a[data-ajax]', function () {
		var self = $(this),
			modal_body = self.closest('.modal-body');
		modal_body.empty().load(self.attr('href'));
		return false;
	});
});