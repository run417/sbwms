const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [5] },
    ],
};

$('#purchase-order-list-table').DataTable(tableOptions);
