(function ($) {

    $(document).ready(function () {
        renderDataTable();
    });

    function renderDataTable() {
        $('#datatable').DataTable({
            'responsive': true,
            "ajax": "get-list",
            "processing": true,
            "serverSide": true,
            "searchDelay": 1000,
            "iDisplayLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columns": [
                { "data": "action", "responsivePriority": 1, "orderable": false,
                    render : function(data, type, full, meta) {
                        var html = '<div style="text-align: center;">';
                            html += '<a class="btn btn-default btn-sm action-edit-inline"' + 
                                        'data-id="' + full.id + '" ' + 
                                        'data-first_name="' + full.first_name + '" ' + 
                                        'data-last_name="' + full.last_name + '"' + 
                                        'data-email="' + full.email + '" ' + 
                                        'data-status="' + full.status + '" ' + 
                                    '>' + 
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' + 
                            '</a>&nbsp;';
                            html += '<a class="btn btn-default btn-sm action-delete-inline" data-id="'+ full.id +'">' + 
                                '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>' + 
                            '</a>';
                            html += '</div>';
                        return html;
                    } 
                },
                { "data": "id", "responsivePriority": 2, "name": "id" },
                { "data": "first_name", "name": "firstName" },
                { "data": "last_name", "name": "lastName" },
                { "data": "email", "name": "email" },
                { "data": "status", "name": "status", 
                    render : function (data, type, full, meta) {
                        var html = '<span class="label label-default">Inactive</span>';
                        if (full.status === 1) {
                            html = '<span class="label label-success">Active</span>';
                        }
                        return html;
                    }
                },
            ],
            "columnDefs": [{
                targets: 1,
                render: function (data, type, row) {
                    return data.substr(0, 10);
                }
            }],
            "drawCallback": function (settings) {
                deleteAction();
                editAction();
            }
        });

        $(".dataTables_filter input").unbind().bind("change", function () {
            searchTerm = $(this).val();
            $('#datatable').DataTable().search(searchTerm).draw();
        });
    }

    function deleteAction() {
        $('.action-delete-inline').on('click', function (e) {
            var data = {
                id: $(this).data('id')
            };
            swal({
                title: "Are you sure you want to delete this record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete',
                        data: data,
                        success: function (result) {
                            swal("Success!", "Record successfully deleted.", "success")
                            reloadView();
                        },
                        error: function (result) {
                            swal("Ohh oh!", result.responseJSON, "error");
                        }
                    });
                }
            });
            e.stopPropagation();
        });
    }

    function editAction() {
        $('.action-edit-inline').on('click', function () { 
            $.magnificPopup.open({
                items: {
                  src: $('#action-popup'),
                  type: 'inline'
                },
                callbacks: {
                    close: function () {
                        $('.edit-action-save').unbind('click');
                    }
                }
            });

            $('#action-popup .panel-title').html('Edit User');

            $('#action-popup input[name="first_name"]').val($(this).data('first_name'));
            $('#action-popup input[name="last_name"]').val($(this).data('last_name'));
            $('#action-popup input[name="email"]').val($(this).data('email'));
            
            $('#action-popup .field-publish').show();
            $('#action-popup .field-publish input[name="status"]').prop(
                'checked', parseInt($(this).data('status')) === 1 ? true : false
            );
            
            $('#action-popup #action-save').removeClass('add-action-save');
            $('#action-popup #action-save').addClass('edit-action-save');

            var id = $(this).data('id');
        
            $('.edit-action-save').on('click', function () {
                $('#action-popup').magnificPopup('close');
                var data = {
                    id: id,
                    first_name: $('#action-popup input[name="first_name"]').val(),
                    last_name: $('#action-popup input[name="last_name"]').val(),
                    email: $('#action-popup input[name="email"]').val(),
                    status: ($('#action-popup input[name="status"]').prop("checked") === true ? 1 : 2)
                };
                $.ajax({
                    type: 'POST',
                    url: 'edit',
                    data: data,
                    success: function () {
                        swal("Success!", "Record successfully edited.", "success");
                        reloadView();
                    },
                    error: function (result) {
                        swal("Ohh oh!", result.responseJSON, "error");
                    }
                });
            });
        });
    }

    function reloadView() {
        $('#datatable').DataTable().ajax.reload();
    }

})(jQuery);
