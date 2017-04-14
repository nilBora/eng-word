
var Core = {
    displayNotice: function(msg, type) {

        jQuery('#js-modal-body').html('<p>'+msg+'</p>');
        if (!type) {
            var type = 'error';
        }

        jQuery('#js-modal-body').find('.modal-title').html(type);

        jQuery('#js-modal-block').fadeIn();
    },

    closeModal: function() {
        jQuery('.js-close-modal').on('click', function(e) {
            e.preventDefault();

            jQuery('#js-modal-block').fadeOut();
        })
    },

    corePost: function(url, data) {
        $.post(url, data, function(response) {
            if (response.error) {
                Core.displayNotice(response.error);

                return true;
            }

            return response;
        });
    }


}

$(function() {
    //$('#system').contents().find('body').html('aaaaaaaaaa');
    Core.closeModal();
})







