const STATUS_COL = 5;
const PRIORITY_COL = 6;

const table = $('#myTable').DataTable({
    order: [[0, 'asc']],
    responsive: false,
    stateSave: true,

    dom: 'Bf t<"bottom"l p i>',

    pageLength: 5,
    pagingType: "simple_numbers",

    language: {
        search: "",
        searchPlaceholder: "Search tickets..."
    },

    buttons: [
        {
            extend: 'excel',
            title: 'Tickets Report',
            exportOptions: {
                columns: ':not(:last-child)'
            }
        },
        {
            extend: 'pdf',
            title: 'Tickets Report',
            exportOptions: {
                columns: ':not(:last-child)'
            }
        }
    ],
});



$('.dt-search-wrapper').append($('.dt-search input'));


// ✅ Export buttons
$('#exportExcelBtn').on('click', function () {
    table.button('.buttons-excel').trigger();
});

$('#exportPdfBtn').on('click', function () {
    table.button('.buttons-pdf').trigger();
});


$('.navsearch-tab').on('click', function () {

    $('.navsearch-tab')
        .removeClass('bg-slate-500 text-white')
        .addClass('bg-slate-100 text-slate-600');

    $(this)
        .removeClass('bg-slate-100 text-slate-600')
        .addClass('bg-slate-500 text-white');

    const filter = $(this).data('filter');

    if (!filter) {
        table.column(STATUS_COL).search('').draw();
    } else {
        table.column(STATUS_COL).search('^' + filter + '$', true, false).draw();
    }
});


$('#filterbtn').on('click', function () {
    $('#showFilter').slideToggle(200);
});

// STATUS dropdown
$('#statusTab').on('change', function () {
    const val = $(this).val();

    if (!val) {
        table.column(STATUS_COL).search('').draw();
    } else {
        table.column(STATUS_COL).search('^' + val + '$', true, false).draw();
    }
});

// PRIORITY dropdown
$('#priority').on('change', function () {
    const val = $(this).val();

    if (!val) {
        table.column(PRIORITY_COL).search('').draw();
    } else {
        table.column(PRIORITY_COL).search('^' + val + '$', true, false).draw();
    }
});


$('.reset').on('click', function () {

    // reset tabs UI
    $('.navsearch-tab')
        .removeClass('bg-slate-500 text-white')
        .addClass('bg-slate-100 text-slate-600');

    // reset dropdowns
    $('#priority').val('');
    $('#statusTab').val('');

    // clear filters
    table.search('').columns().search('').draw();
});