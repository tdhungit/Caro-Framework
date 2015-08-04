jQuery(function() {
    $('a.delete-record').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        BootstrapDialog.show({
            title: 'Warning',
            message: 'Are you sure want to delete this record?',
            buttons: [{
                label: 'No',
                action: function(dialog) {
                    dialog.close();
                }
            }, {
                label: 'Yes',
                action: function(dialog) {
                    dialog.close();
                    location.href = url;
                }
            }]
        });
    });
});
function caro_list_relate(rel_model, current_model, current_id, subpanel_name) {
    $.get(base_url + '/admin/index/popup/' + rel_model + '/' + current_model + '/' + current_id + '/' + subpanel_name, function(data) {
        $('#systemModalContent').html(data);
        $('#systemModal').modal({});
    });
}
function caro_pagination_popup(url) {
    $.get(url, function(data) {
        $('#systemModalContent').html(data);
    });
}
function caro_action_relate(rel_model, rel_id, subpanel_name, current_model, current_id, func) {
    $.post(base_url + '/admin/index/save_relate', {
        rel_model: rel_model,
        rel_id: rel_id,
        subpanel_name: subpanel_name,
        current_model: current_model,
        current_id: current_id,
        func: func
    }, function() {
        window.location.reload();
    });
}
function caro_save_relate(rel_model, rel_id, subpanel_name, current_model, current_id) {
    caro_action_relate(rel_model, rel_id, subpanel_name, current_model, current_id, 'ins');
}
function caro_remove_relate(rel_model, rel_id, subpanel_name, current_model, current_id) {
    caro_action_relate(rel_model, rel_id, subpanel_name, current_model, current_id, 'del');
}
function caro_popup_search(form) {
    var url = form.attr('action') + '?' + form.serialize();
    $.get(url, function(data) {
        $('#systemModalContent').html(data);
    });
}