
var APP = {
	doSendCommand: function() {
		$('.js-send-command').on('click', function(e) {
			e.preventDefault();
			var data = {};
			var $confirm;
			data['command'] = $(this).data('command');

			if ($(this).data('confirm') ) {
				$confirm = $(this).data('confirm');
			}

			if ( $(this).data('confirm') && confirm( $(this).data('confirm'))) {

				Core.corePost('/send/command/', data, function(response) {
					console.log(1);
				})
			} else {
				Core.corePost('/send/command/', data, function(response) {
					console.log(1);
				})
			}
		});
	}


}

$(function() {
	APP.doSendCommand();
})