var Store = {
    init: function() {
        this.onEditRow();
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
    }
}

jQuery(function() {
    Store.init();
})
