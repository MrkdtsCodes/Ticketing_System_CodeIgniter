<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Table</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <!-- jQuery + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">

    <!-- Your CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/CSS/DataTables.css') ?>">

    <!-- DataTables Buttons (EXPORT) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Excel + PDF support -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 p-5">

    <main class="pt-20 px-4 min-h-screen">
        <div class="p-8  mx-auto bg-white rounded-2xl shadow-sm border border-slate-200">


            <div class="dt-search-wrapper mb-2 flex gap-3 items-center bg-white rounded-lg">

                <div class="order-1 text-white bg-blue-500 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
                        <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                    </svg>
                </div>

                <div class="order-1 ">
                    <button id="exportExcelBtn" class="p-3 text-white rounded-lg bg-green-400 flex flex-row px-3 gap-2 items-center justify-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down-icon lucide-file-down">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg></span>
                        Export as Excel
                    </button>
                </div>

                <div class="order-1 ">
                    <button id="exportPdfBtn" class="p-3 text-white rounded-lg bg-red-400 flex flex-row px-3 gap-2 items-center justify-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down-icon lucide-file-down">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg></span>
                        Export as PDF
                    </button>
                </div>
            </div>



            <div class="navsearch flex flex-wrap gap-2 justify-start items-center mb-2">
                <div
                    class="px-9 py-3 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    All</div>
                <div
                    class="px-9 py-3 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    Open</div>
                <div
                    class="px-9 py-3 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    In progress</div>
                <div
                    class="px-9 py-3 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    Resolve</div>
                <div
                    class="px-9 py-3 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                    Closed</div>
            </div>

            <!-- TABLE -->
            <table id="myTable" class="w-full border-separate border-spacing-y-1">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3 text-center font-semibold">Ticket NO.</th>
                        <th class="px-4 py-3 text-center font-semibold">Subject</th>
                        <th class="px-4 py-3 text-center font-semibold">Author</th>
                        <th class="px-4 py-3 text-center font-semibold">PIC(s)</th>
                        <th class="px-4 py-3 text-center font-semibold">Priority</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Created at</th>
                        <th class="px-4 py-3 text-center font-semibold">Updated at</th>
                        <th class="px-4 py-3 text-center font-semibold">Actions</th>
                    </tr>
                </thead>



                <tbody>
                    <?php foreach ($crtdTickets as $ticket): ?>

                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['ticket_code'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['title'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['author_fullname'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['pic_fullname'] ?></td>

                            <td class="px-4 py-3">
                                <div class="prioritybadge inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium"
                                    style="
                                background-color: <?php
                                                    $p = strtolower(trim($ticket['priority']));
                                                    if ($p === 'low') echo '#f0fdf4';
                                                    elseif ($p === 'medium') echo '#fefce8';
                                                    elseif ($p === 'high') echo '#fef2f2';
                                                    else echo '#f1f5f9';
                                                    ?>;
                                border: 1px solid <?php
                                                    if ($p === 'low') echo '#4ade80';
                                                    elseif ($p === 'medium') echo '#facc15';
                                                    elseif ($p === 'high') echo '#f87171';
                                                    else echo '#94a3b8';
                                                    ?>;
                                color: <?php
                                        if ($p === 'low') echo '#16a34a';
                                        elseif ($p === 'medium') echo '#ca8a04';
                                        elseif ($p === 'high') echo '#dc2626';
                                        else echo '#64748b';
                                        ?>;">

                                    <span class="priority"><?= htmlspecialchars($ticket['priority']) ?></span>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div style="color:<?php
                                                    $p = strtolower(trim($ticket['status']));
                                                    if ($p === 'open') echo '#4ade80';
                                                    elseif ($p === 'in progress') echo '#3d76fb';
                                                    elseif ($p === 'for approval') echo '#94a3b8';
                                                    else echo 'red';
                                                    ?>;"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-medium text-slate-700">
                                    <span class="" style="width: 8px; height: 8px; border-radius: 50%; display: inline-block;
                                     background-color: <?php
                                                        $p = strtolower(trim($ticket['status']));
                                                        if ($p === 'open') echo '#4ade80';
                                                        elseif ($p === 'in progress') echo '#3d76fb';
                                                        elseif ($p === 'for approval') echo '#94a3b8';
                                                        else echo 'red';
                                                        ?>;">
                                    </span>
                                    <span class="status_badge"><?= htmlspecialchars($ticket['status']) ?></span>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['created_at'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['updated_at'] ?></td>

                            <td class="px-4 py-3 flex justify-center items-center ">
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
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>


    <script>
        const table = $('#myTable').DataTable({
            order: [
                [0, 'asc']
            ],
            responsive: false,
            stateSave: true,


            dom: 'f t<"bottom"l p i>',

            pageLength: 5,
            pagingType: "simple_numbers",
            language: {
                search: "",
                searchPlaceholder: "Search tickets..."
            },


            buttons: [{
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

        // Move search input into custom wrapper
        $('.dt-search-wrapper').append($('.dt-search input'));
        
        //export buttons
        $('#exportExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        $('#exportPdfBtn').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });
    </script>


</body>

</html>