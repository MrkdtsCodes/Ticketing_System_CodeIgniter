<?php
// Color maps: change the keys to match the exact values stored in your DB
$statusStyles = [
    'open'        => 'bg-blue-50 text-blue-700 ring-blue-600/20',
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


<div class="w-full overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">

    <table class="min-w-full text-sm text-left text-gray-700">

        <!-- Table Header -->
        <thead class="sticky top-0 bg-gray-50 border-b border-gray-200 text-xs font-medium uppercase tracking-wider text-gray-500">
            <tr>
                <th class="px-5 py-3">Ticket Code</th>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Author</th>
                <th class="px-5 py-3">Assigned</th>
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
                                class="rounded-md border border-gray-200 bg-white px-2 py-1 text-xs text-gray-600 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 cursor-pointer" data-tckt_id="<?=$tickets['id']?>">
                                <option value="" selected disabled>Set</option>
                                <option value="view">View</option>
                                <option value="edit">Edit</option>
                                <option value="delete">Delete</option>
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
<script src="<?= base_url('assets/JavaScript/jquery-4.0.0.min.js') ?>"></script>
<script src="<?= base_url('assets/JavaScript/all_tickets_view.js') ?>"></script>
