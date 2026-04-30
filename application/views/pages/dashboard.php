<!DOCTYPE html>
<html lang="en">

<head>
    ...
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
</head>

<body class="bg-slate-50 p-5">

    <main class="pt-20 px-4 min-h-screen">

        <div class="p-8  mx-auto bg-white rounded-2xl shadow-sm border border-slate-200">

            <div class="mb-4 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg"">
                        <!-- LEFT SIDE: Actions -->
                <div class=" dt-search-wrapper flex items-center gap-3 flex-row ">
                            <!-- FILTER ICON -->
                        <div id="filterbtn" class="filterbtn order-1 flex items-center justify-center text-white bg-blue-500 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                            </svg>
                        </div>
                

                    <!-- EXPORT EXCEL -->
                        <button id="exportExcelBtn"
                            class="order-1 px-4 py-3 text-white rounded-lg bg-green-500 flex flex-row items-center gap-2 hover:bg-green-600 transition">
                            Export Excel
                        </button>

                        <!-- EXPORT PDF -->
                        <button id="exportPdfBtn"
                            class="order-1 px-4 py-3 text-white rounded-lg bg-red-500 flex items-center gap-2 hover:bg-red-600 transition">
                            Export PDF
                        </button>
                </div>

                <!-- RIGHT SIDE: NAV SEARCH / FILTER TABS -->
                <div class=" flex items-center justify-end gap-2 flex-row flex-wrap"">

                    <div class="navsearch-tab px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                        hover:bg-slate-500 hover:text-white transition cursor-pointer" data-filter="" id="reset_tab">
                        All
                    </div>

                    <div class="navsearch-tab px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                                    hover:bg-slate-500 hover:text-white transition cursor-pointer" data-filter="open">
                        Open
                    </div>

                    <div class="navsearch-tab px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                                    hover:bg-slate-500 hover:text-white transition cursor-pointer" data-filter="in progress">
                        In progress
                    </div>

                    <div class="navsearch-tab px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                                    hover:bg-slate-500 hover:text-white transition cursor-pointer" data-filter="resolve">
                        Resolve
                    </div>

                    <div class="navsearch-tab px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600
                                    hover:bg-slate-500 hover:text-white transition cursor-pointer" data-filter="closed">
                        Closed
                    </div>

                     <div class="reset px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-white-600
                                    hover:bg-slate-500 hover:text-white transition cursor-pointer">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw-icon lucide-rotate-ccw"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    </div>

                </div>
            </div>

            <div id="showFilter" style="display: none" class="showFilter mb-4 flex w-full justify-center p-4 border border-black items-center gap-4 bg-white rounded-lg">
                
                 <!-- <div class="">
                    <select name="" id="" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option value="" disabled selected>P</option>
                        <option value="">Low</option>
                        <option value="">medium</option>
                        <option value="">High</option>
                    </select>
                </div> -->
                
                <div class="">
                    <select name="" id="priority" class="prioTab w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option  selected value="">-- Select Priority --</option>
                        <option value="low" class="">low</option>
                        <option value="medium" class="">medium</option>
                        <option value="high" class="">High</option>
                    </select>
                </div>

                <div class="">
                    <select  name="" id="" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option disabled selected value="">-- Select Status --</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

               
            </div>

            <!-- TABLE -->
            <table id="myTable" class="w-full border-separate border-spacing-y-1">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-500">
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

                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['ticket_code'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['title'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['author_fullname'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['pic_fullname'] ?></td>

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
                            <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['dept_name'] ?></td>
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

    

<script src="<?= base_url('assets/JavaScript/Color_code.js')?>"></script>
</body>

</html>