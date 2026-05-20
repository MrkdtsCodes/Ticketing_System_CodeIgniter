<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/CSS/DataTables.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <style>
        .dd-wrap { position: relative; display: inline-block; }
        .dd-trigger {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 12px; font-size: 13px; font-weight: 500;
            background: white; border: 1px solid #e2e8f0;
            border-radius: 8px; color: #334155; cursor: pointer;
        }
        .dd-trigger:hover { background: #f8fafc; }
        .dd-menu {
            position: absolute; right: 0; top: calc(100% + 6px);
            min-width: 170px; z-index: 99;
            background: white; border: 1px solid #e2e8f0;
            border-radius: 8px; overflow: hidden; display: none;
        }
        .dd-menu.open { display: block; }
        .dd-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; font-size: 13px;
            color: #334155; cursor: pointer;
            border: none; background: none; width: 100%; text-align: left;
        }
        .dd-item:hover { background: #f8fafc; }
        .dd-item i { font-size: 16px; }
        .dd-item.view i    { color: #64748b; }
        .dd-item.approve i { color: #16a34a; }
        .dd-item.reject i  { color: #dc2626; }
        .dd-item.start i   { color: #0ea5e9; }
        .dd-item.testing i { color: #d97706; }
        .dd-item.pass i    { color: #16a34a; }
        .dd-item.fail i    { color: #dc2626; }
        .dd-divider { height: 1px; background: #f1f5f9; margin: 4px 0; }

        /* Tab styles */
        .nav-tab {
            padding: 6px 18px; border-radius: 6px; font-size: 13px; font-weight: 500;
            border: 1px solid #e2e8f0; background: #f1f5f9; color: #475569;
            cursor: pointer; transition: all .15s;
        }
        .nav-tab:hover { background: #64748b; color: white; }
        .nav-tab.active { background: #475569; color: white; border-color: #475569; }
    </style>
</head>

<body class="bg-slate-50 p-5">
<main class="relative pt-20 px-4 min-h-screen">

    <div id="tabledata" class="p-8 mx-auto bg-white rounded-2xl shadow-sm border border-slate-200">

        <!-- TOP BAR -->
        <div class="mb-4 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg">

            <!-- RIGHT: export + search -->
            <div class="dt-search-wrapper flex items-center gap-3 flex-row">
                <div class="relative group order-1">
                    <div id="filterbtn" class="filterbtn flex items-center justify-center text-white bg-blue-500 p-3 rounded-lg cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/>
                        </svg>
                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap pointer-events-none">Filter Data</span>
                    </div>
                </div>
                <button id="exportExcelBtn" class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-green-500 flex flex-row items-center gap-2 hover:bg-green-600 transition">Export Excel</button>
                <button id="exportPdfBtn"   class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-red-500   flex items-center gap-2 hover:bg-red-600 transition">Export PDF</button>
            </div>

            <!-- LEFT: nav tabs — ALL use data-filter, no hard href -->
            <div class="flex items-center justify-end gap-2 flex-row flex-wrap">
                <button class="nav-tab active" data-filter="">All</button>
                <button class="nav-tab" data-filter="For Approval">For Approval</button>
                <button class="nav-tab" data-filter="Approved">Approved</button>
                <button class="nav-tab" data-filter="Assigned">Assigned</button>
                <button class="nav-tab" data-filter="On Going">On Going</button>
                <button class="nav-tab" data-filter="For Testing">For Testing</button>
                <button class="nav-tab" data-filter="Closed">Closed</button>
            </div>
        </div>

        <!-- FILTER DROPDOWNS -->
        <div id="showFilter" style="display:none" class="mb-4 flex w-full justify-center p-4 border border-black items-center gap-4 bg-white rounded-lg">
            <select id="statusTab" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50">
                <option value="">-- Select Status --</option>
                <option>For Approval</option><option>Approved</option><option>To Assign</option>
                <option>Assigned</option><option>On Going</option><option>For Testing</option>
                <option>Closed</option><option>Rejected</option>
            </select>
            <select id="priority" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50">
                <option value="">-- Select Priority --</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <div class="reset px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                <div class="relative group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap pointer-events-none">Reset filter</span>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <table id="myTable" class="w-full border-separate border-spacing-y-1">
            <thead>
                <tr class="text-xs uppercase tracking-wider text-slate-500">
                    <th class="px-4 py-3 text-center font-semibold">Ticket Age</th>
                    <th class="px-4 py-3 text-center font-semibold">Ticket No.</th>
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
                    <td class="px-4 py-3 text-sm text-slate-700 text-center"><?= $ticket['Ticket_Age'] ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['ticket_code'] ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['title'] ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['author_fullname'] ?></td>

                    <!-- PIC column -->
                    <td class="px-4 py-3 text-sm text-slate-700">
                        <?php
                            $pics = array_filter(explode(', ', $ticket['assigned_employees']));
                            $pic_count = count($pics);
                            if ($pic_count === 0)      echo '<span class="text-slate-400 italic">Not assigned</span>';
                            elseif ($pic_count === 1)  echo htmlspecialchars($ticket['assigned_employees']);
                            else                       echo '<span class="text-xs bg-slate-100 border border-slate-300 rounded px-2 py-0.5">' . $pic_count . ' assigned</span>';
                        ?>
                    </td>

                    <!-- STATUS BADGE -->
                    <td class="px-4 py-3" data-search="<?= htmlspecialchars($ticket['status']) ?>">
                        <div style="color:<?php
                            if ($s==='approved')      echo '#16a34a';
                            elseif($s==='on going')   echo '#0ea5e9';
                            elseif($s==='to assign')  echo '#7c3aed';
                            elseif($s==='assigned')   echo '#2563eb';
                            elseif($s==='for testing')echo '#d97706';
                            elseif($s==='closed')     echo '#6b7280';
                            elseif($s==='rejected')   echo '#dc2626';
                            else                      echo '#64748b';
                        ?>;" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-medium">
                            <span class="w-2 h-2 rounded-full bg-current inline-block"></span>
                            <span><?= htmlspecialchars($ticket['status']) ?></span>
                        </div>
                    </td>

                    <!-- PRIORITY BADGE -->
                    <td class="px-4 py-3" data-search="<?= htmlspecialchars($ticket['priority']) ?>">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                            style="background:<?php echo $p==='low'?'#f0fdf4':($p==='medium'?'#fefce8':'#fef2f2') ?>;
                                   border:1px solid <?php echo $p==='low'?'#4ade80':($p==='medium'?'#facc15':'#f87171') ?>;
                                   color:<?php echo $p==='low'?'#16a34a':($p==='medium'?'#ca8a04':'#dc2626') ?>">
                            <?= htmlspecialchars(strtolower($ticket['priority'])) ?>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-700"><?= $ticket['dept_name'] ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= date('M d, Y g:i A', strtotime($ticket['created_at'])) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= date('M d, Y g:i A', strtotime($ticket['updated_at'])) ?></td>

                    <!-- ACTIONS -->
                    <td class="px-4 py-3 text-sm text-slate-700">
                        <div class="dd-wrap">
                            <button class="dd-trigger" type="button">
                                Actions <i class="ti ti-chevron-down"></i>
                            </button>
                            <div class="dd-menu">
                                <!-- Always: View -->
                                <a href="<?= base_url('tickets/details/view/' . $ticket['id']) ?>">
                                    <button class="dd-item view" type="button">
                                        <i class="ti ti-eye"></i> View ticket
                                    </button>
                                </a>

                                <!-- For Approval: Approve / Reject -->
                        
                      
                               <?php 
                                $role = $this->session->userdata('role_name');
                                if( $role === "Admin"):?>

                                    <?php if ($s === 'for approval'): ?>
                                            <div class="dd-divider"></div>
                                            <button class="dd-item approve approveButton" type="button"
                                                data-id="<?= $ticket['id'] ?>"
                                                data-title="<?= htmlspecialchars($ticket['title']) ?>"
                                                data-code="<?= $ticket['ticket_code'] ?>"
                                                data-author="<?= htmlspecialchars($ticket['author_fullname']) ?>">
                                                <i class="ti ti-circle-check"></i> Approve
                                            </button>
                                            <a href="<?= base_url('tickets/status/rejected/' . $ticket['id']) ?>">
                                                <button class="dd-item reject" type="button">
                                                    <i class="ti ti-circle-x"></i> Reject
                                                </button>
                                            </a>
                                    <?php endif; ?>

                               <?php endif?>

                                <!-- Assigned: Start Working
                                <?php if ($s === 'assigned'): ?>
                                    <div class="dd-divider"></div>
                                    <a href="<?= base_url('tickets/status/ongoing/' . $ticket['id']) ?>">
                                        <button class="dd-item start" type="button">
                                            <i class="ti ti-player-play"></i> Start working
                                        </button>
                                    </a>
                                <?php endif; ?>

                                On Going: Submit for Testing
                                <?php if ($s === 'on going'): ?>
                                    <div class="dd-divider"></div>
                                    <a href="<?= base_url('tickets/status/fortesting/' . $ticket['id']) ?>">
                                        <button class="dd-item testing" type="button">
                                            <i class="ti ti-send"></i> Submit for testing
                                        </button>
                                    </a>
                                <?php endif; ?>

                                For Testing: Pass / Fail
                                <?php if ($s === 'for testing'): ?>
                                    <div class="dd-divider"></div>
                                    <a href="<?= base_url('tickets/status/closed/completed/' . $ticket['id']) ?>">
                                        <button class="dd-item pass" type="button">
                                            <i class="ti ti-check"></i> Pass testing
                                        </button>
                                    </a>
                                    <a href="<?= base_url('tickets/status/ongoing/' . $ticket['id']) ?>">
                                        <button class="dd-item fail" type="button">
                                            <i class="ti ti-x"></i> Fail – send back
                                        </button>
                                    </a>
                                <?php endif; ?> -->

                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<!-- APPROVE MODAL (unchanged from your original) -->
<div id="approveModal" style="display:none;" class="absolute top-1 left-1/2 transform -translate-x-1/2 translate-y-1/2 z-40 w-full max-w-md">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
            <div>
                <p class="text-xs text-slate-400 mb-1">You are about to approve</p>
                <div class="flex items-center gap-2 mt-2">
                    <span id="modal-code" class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full"></span>
                    <span id="modal-author" class="text-xs text-slate-400"></span>
                </div>
            </div>
            <button id="backbutton" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <form id="approveForm" method="POST">
            <div class="px-5 py-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Set priority before approving</p>
                <div class="flex flex-col gap-2">
                    <label id="lbl-low" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-green-300 hover:bg-green-50">
                        <input type="radio" name="modal_priority" value="low" class="w-4 h-4 accent-green-600">
                        <span class="w-2 h-2 rounded-full bg-green-600 shrink-0"></span>
                        <div class="flex-1"><p class="text-sm font-medium text-slate-700">Low</p><p class="text-xs text-slate-400">Not urgent, can be handled when time permits</p></div>
                        <span class="text-xs font-medium bg-green-50 text-green-700 border border-green-200 px-2.5 py-0.5 rounded-full">low</span>
                    </label>
                    <label id="lbl-medium" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-amber-300 hover:bg-amber-50">
                        <input type="radio" name="modal_priority" value="medium" class="w-4 h-4 accent-amber-600">
                        <span class="w-2 h-2 rounded-full bg-amber-600 shrink-0"></span>
                        <div class="flex-1"><p class="text-sm font-medium text-slate-700">Medium</p><p class="text-xs text-slate-400">Needs attention soon, moderate impact</p></div>
                        <span class="text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-full">medium</span>
                    </label>
                    <label id="lbl-high" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-red-300 hover:bg-red-50">
                        <input type="radio" name="modal_priority" value="high" class="w-4 h-4 accent-red-600">
                        <span class="w-2 h-2 rounded-full bg-red-600 shrink-0"></span>
                        <div class="flex-1"><p class="text-sm font-medium text-slate-700">High</p><p class="text-xs text-slate-400">Urgent, must be resolved immediately</p></div>
                        <span class="text-xs font-medium bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full">high</span>
                    </label>
                </div>
                <div class="mt-3 flex gap-2 items-start p-3 bg-amber-50 border border-amber-200 rounded-xl">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    <p class="text-xs text-amber-700 leading-relaxed">Priority cannot be changed after approval. Please review the ticket carefully before confirming.</p>
                </div>
            </div>
            <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" id="cancelApprove" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">Cancel</button>
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition bg-green-700 hover:bg-green-800">
                    <i class="ti ti-circle-check"></i> Approve &amp; Set Priority
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const STATUS_COL = 5;
const PRIORITY_COL = 6;

const table = $('#myTable').DataTable({
    order: [[0, 'asc']],
    responsive: false,
    stateSave: true,
    dom: 'f t<"bottom"l p i>',
    pageLength: 10,
    pagingType: "simple_numbers",
    language: {
        search: "",
        searchPlaceholder: "Search tickets..."
    },
    buttons: [
        { extend: 'excel', title: 'Tickets Report', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'pdf',   title: 'Tickets Report', exportOptions: { columns: ':not(:last-child)' } }
    ],
    columnDefs: [
        { targets: STATUS_COL,   searchable: true, render: function(data, type, row) {
            if (type === 'filter' || type === 'search') return $(row).find('[data-search]').data('search') || data;
            return data;
        }},
        { targets: PRIORITY_COL, searchable: true }
    ]
});

$('.dt-search-wrapper').append($('.dt-search input'));

$('#exportExcelBtn').on('click', function() { table.button('.buttons-excel').trigger(); });
$('#exportPdfBtn').on('click',   function() { table.button('.buttons-pdf').trigger(); });

// ── TAB FILTERING ────────────────────────────────────────────────────────────
$(document).on('click', '.nav-tab', function() {
    $('.nav-tab').removeClass('active');
    $(this).addClass('active');

    const filter = $(this).data('filter');
    if (!filter) {
        table.column(STATUS_COL).search('').draw();
    } else {
        table.column(STATUS_COL).search('^' + filter + '$', true, false).draw();
    }
});

// ── FILTER PANEL ─────────────────────────────────────────────────────────────
$('#filterbtn').on('click', function() { $('#showFilter').slideToggle(200); });

$('#statusTab').on('change', function() {
    const val = $(this).val();
    table.column(STATUS_COL).search(val ? '^' + val + '$' : '', true, false).draw();
});

$('#priority').on('change', function() {
    const val = $(this).val();
    table.column(PRIORITY_COL).search(val ? '^' + val + '$' : '', true, false).draw();
});

$('.reset').on('click', function() {
    $('#priority').val(''); $('#statusTab').val('');
    $('.nav-tab').removeClass('active');
    $('[data-filter=""]').addClass('active');
    table.search('').columns().search('').draw();
});

// ── DROPDOWN TOGGLE ───────────────────────────────────────────────────────────
$(document).on('click', '.dd-trigger', function(e) {
    e.stopPropagation();
    const menu = $(this).next('.dd-menu');
    $('.dd-menu.open').not(menu).removeClass('open');
    menu.toggleClass('open');
});
$(document).on('click', function() { $('.dd-menu.open').removeClass('open'); });

// ── APPROVE MODAL ─────────────────────────────────────────────────────────────
const approveModal = document.getElementById('approveModal');
const tabledata    = document.getElementById('tabledata');

$(document).on('click', '.approveButton', function() {
    document.getElementById('modal-code').textContent   = this.dataset.code;
    document.getElementById('modal-author').textContent = this.dataset.author;
    document.getElementById('approveForm').action = "<?= base_url('tickets/status/approved/') ?>" + this.dataset.id;
    approveModal.style.display = 'block';
    tabledata.classList.add('blur-sm');
});

$('#backbutton, #cancelApprove').on('click', function() {
    approveModal.style.display = 'none';
    tabledata.classList.remove('blur-sm');
});
</script>

</body>
</html>