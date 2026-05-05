<!DOCTYPE html>
<html lang="en">

<head>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.css"
        rel="stylesheet" integrity="sha384-KqCux+UMRtmKJpx+3FvAaZ0245U9Ef/GVNvlKYMhDvODlThuTnGhxo1hmcmyTIkw"
        crossorigin="anonymous">

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/CSS/DataTables.css') ?>">

    <!-- pdfmake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"
        integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"
        integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n"
        crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.js"
        integrity="sha384-EeU0n4QZjxAoReXoJNbWIsbYCFLxs2/K2hduD34zPKu6IIhf91rgg8v/AR12rnk0"
        crossorigin="anonymous"></script>
</head>

<body class="bg-slate-50 p-5">

    <main class="pt-20 px-4 min-h-screen">

        <div class="p-8 mx-auto bg-white rounded-2xl shadow-sm border border-slate-200">

            <div class="mb-4 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg">
                <!-- LEFT SIDE: Actions -->
                <div class="dt-search-wrapper flex items-center gap-3 flex-row">
                    <!-- FILTER ICON -->
                    <div id="filterbtn"
                        class="filterbtn order-1 flex items-center justify-center text-white bg-blue-500 p-3 rounded-lg cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                        </svg>
                    </div>

                    <!-- EXPORT EXCEL -->
                    <button id="exportExcelBtn"
                        class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-green-500 flex flex-row items-center gap-2 hover:bg-green-600 transition">
                        Export Excel
                    </button>

                    <!-- EXPORT PDF -->
                    <button id="exportPdfBtn"
                        class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-red-500 flex items-center gap-2 hover:bg-red-600 transition">
                        Export PDF
                    </button>
                </div>

                <!-- RIGHT SIDE: NAV TABS -->
                <div class="flex items-center justify-end gap-2 flex-row flex-wrap">

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer" ">
                        All
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-500 border border-slate-200 text-white
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        For Approval
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        To Assign
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        Assigned
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        On going
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        For Testing
                    </div>

                    <div class=" px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer">
                        Closed
                    </div>

                </div>
            </div>

            <!-- FILTER DROPDOWNS -->
            <div id="showFilter" style="display: none"
                class="showFilter mb-4 flex w-full justify-center p-4 border border-black items-center gap-4 bg-white rounded-lg">


                <!-- Status Dropdown -->
                <div class="">
                    <select name="" id="statusTab"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option selected value="">-- Select Status --</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="For Approval">For Approval</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>

                <!-- Priority Dropdown -->
                <div class="">
                    <select name="" id="priority"
                        class="prioTab w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option selected value="">-- Select Priority --</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>



                <!-- Reset Button -->
                <div class="reset px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                    hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                </div>

            </div>

            <table id="myTable" class="w-full border-separate border-spacing-y-1">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3 text-center font-semibold">Ticket Age.</th>
                        <th class="px-4 py-3 text-center font-semibold">Ticket NO.</th>
                        <th class="px-4 py-3 text-center font-semibold">Subject</th>
                        <th class="px-4 py-3 text-center font-semibold">Author</th>
                        <th class="px-4 py-3 text-center font-semibold">PIC(s)</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Priority</th>
                        <th class="px-4 py-3 text-center font-semibold">Department</th>
                        <th class="px-4 py-3 text-center font-semibold">Created at</th>
                        <th class="px-4 py-3 text-center font-semibold">Updated at</th>
                        <th class="px-4 py-3 text-center font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($crtdTickets as $ticket): ?>

                        <?php
                        $s = strtolower(trim($ticket['status']));
                        $p = strtolower(trim($ticket['priority']));
                        ?>

                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['ticket_age'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['ticket_code'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['title'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['author_fullname'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['pic_fullname'] ?></td>


                            <td class="px-4 py-3" data-search="<?= $ticket['status'] ?>">
                                <div style="color:<?php
                                if ($s === 'open')
                                    echo '#4ade80';
                                elseif ($s === 'in progress')
                                    echo '#3d76fb';
                                elseif ($s === 'for approval')
                                    echo '#94a3b8';
                                elseif ($s === 'closed')
                                    echo '#ef4444';
                                else
                                    echo '#64748b';
                                ?>;"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-medium">


                                    <span class="w-2 h-2 rounded-full bg-current inline-block"></span>

                                    <span class="status_badge"><?= htmlspecialchars($ticket['status']) ?></span>
                                </div>
                            </td>


                            <td class="px-4 py-3" data-search="<?= $ticket['priority'] ?>">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium"
                                    style="
                        background-color: <?php
                        if ($p === 'low')
                            echo '#f0fdf4';
                        elseif ($p === 'medium')
                            echo '#fefce8';
                        elseif ($p === 'high')
                            echo '#fef2f2';
                        else
                            echo '#f1f5f9';
                        ?>;
                        border: 1px solid <?php
                        if ($p === 'low')
                            echo '#4ade80';
                        elseif ($p === 'medium')
                            echo '#facc15';
                        elseif ($p === 'high')
                            echo '#f87171';
                        else
                            echo '#94a3b8';
                        ?>;
                        color: <?php
                        if ($p === 'low')
                            echo '#16a34a';
                        elseif ($p === 'medium')
                            echo '#ca8a04';
                        elseif ($p === 'high')
                            echo '#dc2626';
                        else
                            echo '#64748b';
                        ?>;">

                                    <span class="priority"><?= htmlspecialchars($ticket['priority']) ?></span>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['dept_name'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['created_at'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['updated_at'] ?></td>

                            <td class="px-4 py-3 flex justify-center items-center">
                                <a href="<?= base_url('tickets/view/' . $ticket['id']) ?>">
                                    <button
                                        class="text-slate-500 hover:text-slate-900 hover:bg-slate-100 p-2 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>

    <script>
        const STATUS_COL = 5;
        const PRIORITY_COL = 6;

        const table = $('#myTable').DataTable({
            order: [[0, 'asc']],
            responsive: false,
            stateSave: true,

            dom: 'f t<"bottom"l p i>',

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
    </script>
</body>

</html>