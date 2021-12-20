var oTable;

$(function() {
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        colReorder: true,
        dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });
    $('.table-operation').DataTable({
        // columnDefs: [
        //     {
        //         orderable: false,
        //         className: 'select-checkbox',
        //         targets: 0
        //     },
        //     {
        //         orderable: false,
        //         width: '100px',
        //         targets: 6
        //     }
        // ],
        // select: {
        //     style: 'os',
        //     selector: 'td:first-child'
        // },
        order: [[1, 'asc']]
    });
});

function delivery() {
    //alert(1);
    window.location.href = $('#base_url').val()+"sales/order/delivery";
}
