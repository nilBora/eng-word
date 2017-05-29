var Store = {
    init: function() {
        this.onEditRow();
    },
    
    onEditRow: function() {
        jQuery('.js-edit-row').on('click', function(e) {
            e.preventDefault();
            jQuery.post('/admin/users/', {}, function(data) {
                 
            });
        })
    }
}

jQuery(function() {
    Store.init();
})
