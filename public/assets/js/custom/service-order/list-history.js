const tableOptions = {
    paging: true,
    searching: true,
    order: [
        [2, 'asc'],
        [0, 'desc'],
    ],
    columnDefs: [{ orderable: false, targets: [4] }],
};

const table = $('#service-order-history-table').DataTable(tableOptions);
