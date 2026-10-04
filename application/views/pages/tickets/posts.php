<?php
// Color maps: change the keys to match the exact values stored in your DB
$statusStyles = [
    'approved'        => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'in progress' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
    'resolved'    => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
    'closed'      => 'bg-gray-100 text-gray-600 ring-gray-500/20',
];
$priorityDots = [
    'low'    => 'bg-emerald-500',
    'medium' => 'bg-amber-500',
    'high'   => 'bg-red-500',
];
?>


<div class="tickets_table_list w-full overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">

    <table class="min-w-full text-sm text-left text-gray-700">

        <!-- Table Header -->
        <thead class="sticky top-0 bg-gray-50 border-b border-gray-200 text-xs font-medium uppercase tracking-wider text-gray-500">
            <tr>
                <th class="px-5 py-3">Ticket Code</th>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Author</th>
                <th class="px-5 py-3">PIC(s)</th>
                <th class="px-5 py-3">Department</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Priority</th>
                <th class="px-5 py-3">Created</th>
                <th class="px-5 py-3">Updated</th>
                <th class="px-5 py-3 text-center">Actions</th>
            </tr>
        </thead>

        <!-- Table Body -->
        <tbody class="divide-y divide-gray-100">
            <?php if (!empty($crtdTickets)): ?>
                <?php foreach ($crtdTickets as $tickets): ?>
                    <?php
                        $statusKey   = strtolower($tickets['status']);
                        $priorityKey = strtolower($tickets['priority']);
                        $statusClass = $statusStyles[$statusKey] ?? 'bg-gray-100 text-gray-600 ring-gray-500/20';
                        $dotClass    = $priorityDots[$priorityKey] ?? 'bg-gray-400';
                    ?>
                    <tr class="hover:bg-gray-50/70 transition-colors duration-150">

                        <!-- Ticket code -->
                        <td class="px-5 py-4">
                            <span class="font-mono text-xs font-medium text-blue-600">
                                <?= html_escape($tickets['ticket_code']) ?>
                            </span>
                        </td>

                        <!-- Title -->
                        <td class="px-5 py-4 font-medium text-gray-900 max-w-xs truncate">
                            <?= html_escape($tickets['title']) ?>
                        </td>

                        <!-- Author -->
                        <td class="px-5 py-4 text-gray-600">
                            <?= html_escape($tickets['author_fullname']) ?>
                        </td>

                        <!-- Assigned employee -->
                        <td class="px-5 py-4 text-gray-600">
                            <?php if (!empty($tickets['assigned_fullname'])): ?>
                                <?= html_escape($tickets['assigned_fullname']) ?>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Unassigned</span>
                            <?php endif; ?>
                        </td>

                        <!-- Department -->
                        <td class="px-5 py-4 text-gray-600">
                            <?= html_escape($tickets['dept_name']) ?>
                        </td>

                        <!-- Status badge -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset <?= $statusClass ?>">
                                <?= html_escape($tickets['status']) ?>
                            </span>
                        </td>

                        <!-- Priority with colored dot -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-2 text-gray-700">
                                <span class="h-2 w-2 rounded-full <?= $dotClass ?>"></span>
                                <?= html_escape($tickets['priority']) ?>
                            </span>
                        </td>

                        <!-- Dates -->
                        <td class="px-5 py-4 whitespace-nowrap text-gray-500">
                            <?= date('M j, Y', strtotime($tickets['created_at'])) ?>
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap text-gray-500">
                            <?= date('M j, Y', strtotime($tickets['updated_at'])) ?>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-center">
                            <select name="ticket_list" id="ticket_list"
                                class="rounded-md border border-gray-200 bg-white px-2 py-1 text-xs text-gray-600 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 cursor-pointer" data-tckt_id="<?=$tickets['id']?>"
                                data-tckt_code="<?=$tickets['ticket_code']?>"
                                data-author_name="<?=$tickets['author_fullname']?>"
                                >
                                <option value="" selected disabled>Actions</option>
                                <option value="view">View</option>
                                <option value="approved">Approved</option>
                                <option value="reject">Reject</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="px-5 py-12 text-center text-gray-400">
                        No tickets found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>

        <!-- Footer / Pagination -->
        <tfoot class="border-t border-gray-200 bg-gray-50">
            <tr>
                <td colspan="10" class="px-5 py-3">
                    <?php if (!empty($links)): ?>
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                Showing <span class="font-medium text-gray-700"><?= $total_rows; ?></span> tickets
                            </div>
                            <div class="pagination">
                                <?= $links; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-xs text-gray-400">No more pages</div>
                    <?php endif; ?>
                </td>
            </tr>
        </tfoot>

    </table>
</div>


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
<script src="<?= base_url('assets/JavaScript/jquery-4.0.0.min.js') ?>"></script>
<script src="<?= base_url('assets/JavaScript/all_tickets_view.js') ?>"></script>
