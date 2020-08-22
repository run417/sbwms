const filterBtn = $('#filter-btn');
const allDatesCheckbox = $('#all-dates');
const date = $('#date-filter');
const employee = $('#employee');

const tableOptions = {
    paging: true,
    searching: true,
    order: [
        [2, 'asc'],
        [0, 'desc'],
    ],
    dom: 'Bfrtip',
    buttons: ['print', 'pdf'],
    columnDefs: [{ orderable: false, targets: [4] }],
};

$('#date-filter').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
});

const table = $('#schedule-table').DataTable(tableOptions);

filterBtn.on('click', handleFiltering);
allDatesCheckbox.on('click', handleCheckBox);
$('#date-filter').on('changeDate', handlePopulate);

function handlePopulate() {
    $('#all-dates').prop('checked', false);
}

function handleCheckBox() {
    if (this.checked) {
        date.val('');
    }
}

function handleFiltering() {
    console.log(date.val(), employee.val());
    let dateValue = date.val();
    let idValue = employee.val();
    if (dateValue === '') {
        dateValue = 'all';
    }
    loadSchedule(dateValue, idValue).done((response) => {
        table.destroy();
        $('#schedule-list').empty().append(response);
        $('#schedule-table').DataTable(tableOptions);
    });
}

function loadSchedule(dateValue, id) {
    console.log(dateValue, id);
    return $.ajax({
        method: 'GET',
        data: {
            date: dateValue,
            id: id,
        },
        url: urlFor('/schedule/filter'),
        dataType: 'html',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}
