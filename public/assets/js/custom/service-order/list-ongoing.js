const tableOptions = {
    paging: true,
    searching: true,
    order: [[3, 'asc'], [0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [5] },
    ],
};

const table = $('#ongoing-service-order-table').DataTable(tableOptions);
