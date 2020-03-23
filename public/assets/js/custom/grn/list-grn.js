const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [4] },
    ],
};

$('#grn-list-table').DataTable(tableOptions);
