(function ($) {

    $(document).ready(function () {
        onLoadDataTable();
        onLoadTotalExpenses();
        onLoadTotalDays();
        addAction();
        $('input[name="date"]').datepicker({ dateFormat: 'yy-mm-dd' });
    });

    function reloadView() {
        $('#datatable').DataTable().ajax.reload();
        onLoadTotalExpenses();
        onLoadTotalDays();
    }

    function onLoadDataTable() {
        $('#datatable').DataTable( {
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
                                        'data-type="' + full.type + '" ' + 
                                        'data-label="' + full.label + '"' + 
                                        'data-cost="' + full.cost + '" ' + 
                                        'data-date="' + full.date + '" ' + 
                                    '>' + 
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' + 
                            '</a>&nbsp;';

                            html += '<a class="btn btn-default btn-sm action-delete-inline" data-id="'+ full.id +'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                            html += '</div>';
                        return html;
                    } 
                },
                { "data": "id", "responsivePriority": 2, "name": "id" },
                { "data": "type", "name": "type" , 
                    render : function (data, type, full, meta) {
                        switch (full.type) {
                            case 1:
                                return '<span class="label label-primary">Communication</span>';
                            case 2:
                                return '<span class="label label-warning">Transportation</span>';
                            case 3:
                                return '<span class="label label-danger">Representation</span>';
                            case 4:
                                return '<span class="label label-default">Sundries</span>';
                            default:
                                return '<span class="label label-default">Unknown</span>';
                        }
                    }
                },
                { "data": "label", "name": "label" },
                { "data": "cost", "name": "cost", 
                    render: function (data, type, full, meta) {
                        return numberWithCommas(full.cost);
                    }    
                },
                { "data": "date", "name": "date" },
                { "data": "created_at", "name": "createdAt" },
            ],
            "order": [[ 6, "DESC" ]],
            "columnDefs": [{
                targets: 1,
                render: function(data, type, row) {
                    return data.substr(0, 10);
                }
            }],
            "drawCallback": function(settings) {
                deleteAction();
                editAction();
            }
        });

        $(".dataTables_filter input").unbind().bind("change, focusout", function () {
            searchTerm = $(this).val();
            $('#datatable').DataTable().search(searchTerm).draw();
        });
    }

    function onLoadTotalExpenses() {
        $.ajax({
            type: 'GET',
            url: 'get-total-expenses',
            data: {},
            success: function (result) {
                $('#total-expenses').html(numberWithCommas(result.total));
            },
            error: function (result) {
                console.error(result.responseJSON)
            }
        });
    }

    function onLoadTotalDays() {
        $.ajax({
            type: 'GET',
            url: 'get-total-days',
            data: {},
            success: function (result) {
                $('#total-days').html(result.total);
            },
            error: function (result) {
                console.error(result.responseJSON)
            }
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
                    close: function(){
                        $('.edit-action-save').unbind('click');
                    }
                }
            });

            $('#action-popup .panel-title').html('Edit Expense');
            $('#action-popup select[name="type"]').val($(this).data('type'));
            $('#action-popup input[name="label"]').val($(this).data('label'));
            $('#action-popup input[name="cost"]').val($(this).data('cost'));
            $('#action-popup input[name="date"]').val($(this).data('date'));
            $('#action-popup #action-save').removeClass('add-action-save');
            $('#action-popup #action-save').addClass('edit-action-save');

            var id = $(this).data('id');
        
            $('.edit-action-save').on('click', function () {
                var data = {
                    id: id,
                    type: $('#action-popup select[name="type"]').val(),
                    label: $('#action-popup input[name="label"]').val(),
                    cost: $('#action-popup input[name="cost"]').val(),
                    date: $('#action-popup input[name="date"]').val(),
                };
                $.ajax({
                    type: 'POST',
                    url: 'edit',
                    data: data,
                    success: function () {
                        $('#action-popup').magnificPopup('close');
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

    function addAction() {
        $('.action-add-expense-entry').on('click', function () {
            $.magnificPopup.open({
                items: {
                  src: $('#action-popup'),
                  type: 'inline'
                },
                callbacks: {
                    close: function(){
                        $('.add-action-save').unbind('click');
                    }
                }
            });
            
            $('#action-popup .panel-title').html('Add Expense');
            $('#action-popup select[name="type"]').val('1');
            $('#action-popup input[name="label"]').val('');
            $('#action-popup input[name="cost"]').val('');
            $('#action-popup input[name="date"]').val('');
            $('#action-popup #action-save').removeClass('edit-action-save');
            $('#action-popup #action-save').addClass('add-action-save');

            $('.add-action-save').on('click', function () {
                var data = {
                    type: $('#action-popup select[name="type"]').val(),
                    label: $('#action-popup input[name="label"]').val(),
                    cost: $('#action-popup input[name="cost"]').val(),
                    date: $('#action-popup input[name="date"]').val(),
                };
                $.ajax({
                    type: 'POST',
                    url: 'add',
                    data: data,
                    success: function () {
                        $('#action-popup').magnificPopup('close');
                        swal("Success!", "Record successfully added.", "success");
                        reloadView();
                    },
                    error: function (result) {
                        swal("Ohh oh!", result.responseJSON, "error");
                    }
                });
            });
        });
    }

    function kFormatter(num) {
        return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
})(jQuery);
