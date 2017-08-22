var Store = {
    init: function() {
        this.onEditRow();
        this.onCloseModal();
    },
    
    onEditRow: function() {
        jQuery('.js-edit-row').on('click', function(e) {
            e.preventDefault();
            var id = jQuery(this).data('id');
            jQuery.post(window.location.pathname, {'id': id, 'ajax': true, 'edit': true}, function(data) {
                 jQuery('body').append(data);
                 jQuery('.js-table-edit').modal();
            });
        })
    },
    
    onCloseModal: function() {
        jQuery('body').on('hide.bs.modal', '.js-table-edit', function () {
            jQuery(this).detach();
        });
    }
}

jQuery(function() {
    Store.init();
})
