(function ($) {

    $(document).ready(function () {
        bindEvents();
    });

    function bindEvents() {
        registerExpenseDateJqueryDatePickerBinding();
        registerActionAddExpenseEntryOnClickBinding();
    }

    function registerExpenseDateJqueryDatePickerBinding() {
        $('input[name="expense_date"]').datepicker();
    }

    function registerActionAddExpenseEntryOnClickBinding() {
        $('.action-add-expense-entry').on('click', function () {
            $.magnificPopup.open({
                items: {
                  src: $('#action-popup'),
                  type: 'inline'
                },
                callbacks: {
                    close: function(){
                        $('.add-action-submit').unbind('click');
                    }
                }
            });
            _clearActionAddExpenseEntryFormFields();
        });
    }

    function _clearActionAddExpenseEntryFormFields() {
        $('#action-popup .panel-title').html('Add Expense Entry');
        $('#action-popup input[name="expense_label"]').val('');
        $('#action-popup input[name="expense_cost"]').val('');
        $('#action-popup input[name="expense_date"]').val('');
        $('#action-popup #action-submit').removeClass('edit-action-submit');
        $('#action-popup #action-submit').addClass('add-action-submit');
    }

})(jQuery);
