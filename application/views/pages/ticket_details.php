<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ticket Detail</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.css"
        rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.js"
        crossorigin="anonymous"></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        const BASE_URL = "<?= base_url() ?>";
    </script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.0/fonts/tabler-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9999px; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <main class="p-6 md:p-10 mt-14">
        <div id="tabledata"
            class="relative max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg flex items-center gap-2">
                    <i class="ti ti-circle-check text-base"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg flex items-center gap-2">
                    <i class="ti ti-alert-circle text-base"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                <div class="flex-1 min-w-0">
                    <h1 class="font-semibold text-gray-800 text-base mb-2">
                        <?= strtoupper($tckt_details['title']) ?>
                    </h1>
                    <div class="flex flex-wrap items-center gap-2">

                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <i class="ti ti-ticket text-sm"></i>
                            <?= $tckt_details['ticket_code'] ?>
                        </span>

                        <?php
                            $status = strtolower(trim($tckt_details['status']));
                            if ($status === 'approved')        { $sc = 'bg-green-50 text-green-700 border border-green-200'; }
                            elseif ($status === 'on going')    { $sc = 'bg-blue-50 text-blue-700 border border-blue-200'; }
                            elseif ($status === 'rejected')    { $sc = 'bg-red-50 text-red-700 border border-red-200'; }
                            elseif ($status === 'for approval'){ $sc = 'bg-amber-50 text-amber-700 border border-amber-200'; }
                            else                               { $sc = 'bg-gray-100 text-gray-600 border border-gray-200'; }
                        ?>
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full <?= $sc ?>">
                            <i class="ti ti-clock-check text-sm"></i>
                            <?= htmlspecialchars(ucfirst(strtolower($tckt_details['status']))) ?>
                        </span>

                        <?php
                            $p = strtolower(trim($tckt_details['priority'] ?? ''));
                            if ($p === 'low')        { $pc = 'bg-green-50 text-green-700 border border-green-200'; }
                            elseif ($p === 'medium') { $pc = 'bg-yellow-50 text-yellow-700 border border-yellow-200'; }
                            elseif ($p === 'high')   { $pc = 'bg-red-50 text-red-700 border border-red-200'; }
                            else                     { $pc = 'bg-gray-100 text-gray-500 border border-gray-200'; }
                        ?>
                        <?php if (!empty($tckt_details['priority'])): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full <?= $pc ?>">
                                <i class="ti ti-flag text-sm"></i>
                                <?= htmlspecialchars(ucfirst(strtolower($tckt_details['priority']))) ?>
                            </span>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 shrink-0">

                     <button
                        id=""
                        data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>"
                        data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>"
                        data-status="<?= $tckt_details['status'] ?>"
                        data-departmentID="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-git-fork-icon lucide-git-fork"><circle cx="12" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><circle cx="18" cy="6" r="3"/><path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9"/><path d="M12 12v3"/></svg>
                        <span>Ticket Timeline</span>
                    </button>

                    <button
                        id="ReassignEmpBtn"
                        data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>"
                        data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>"
                        data-status="<?= $tckt_details['status'] ?>"
                        data-departments="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2"><path d="M10 12h4"/><path d="M10 8h4"/><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/></svg>
                        <span>Re-Assign Department</span>
                    </button>

                    <button
                        id="AssignEmployeeBtn"
                        data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>"
                        data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>"
                        data-status="<?= $tckt_details['status'] ?>"
                        data-departmentID="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>
                        <span>Assign Employee</span>
                    </button>

                </div>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">

                <div class="p-6 space-y-6">

                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Ticket Details</h2>

                    <div class="flex flex-wrap gap-2">
                        <span title="Department"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-building text-sm"></i>
                            <?= htmlspecialchars($tckt_details['dept_name'] ?? 'No department') ?>
                        </span>
                        <span title="Author"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-user text-sm"></i>
                            <?= htmlspecialchars($tckt_details['author_fullname'] ?? 'Unknown') ?>
                        </span>
                        <span id="assigned_employees" title="PIC's"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-user-check text-sm"></i>
                            <?= $tckt_details['assigned_employees'] !== null
                                ? htmlspecialchars($tckt_details['assigned_employees'])
                                : 'Not assigned yet' ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Date Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('M d, Y', strtotime($tckt_details['created_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Time Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('g:i A', strtotime($tckt_details['created_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Last Updated</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('M d, Y g:i A', strtotime($tckt_details['updated_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Ticket Age</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= $tckt_details['Ticket_Age'] ?>
                                <?= $tckt_details['Ticket_Age'] == 1 ? 'day' : 'days' ?>
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-100" />

                    <div>
                        <p class="text-xs text-gray-400 italic mb-3">
                            Detail the request — problem, hypothesis, and proposed solution.
                        </p>
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                            <p>
                                <span class="font-semibold text-blue-700">Issue: </span>
                                <?= htmlspecialchars($tckt_details['body']) ?>
                            </p>
                        </div>
                    </div>

                    <?php if (!empty($attachments)): ?>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">
                                Attachments (<?= count($attachments) ?>)
                            </p>
                            <div class="flex flex-col gap-2">
                                <?php foreach ($attachments as $file):
                                    $ext = strtolower($file['file_type']);
                                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $icon = 'ti-photo';
                                        $color = 'text-blue-500 bg-blue-50 border-blue-100';
                                    } elseif ($ext === 'pdf') {
                                        $icon = 'ti-file-type-pdf';
                                        $color = 'text-red-500 bg-red-50 border-red-100';
                                    } elseif (in_array($ext, ['doc', 'docx'])) {
                                        $icon = 'ti-file-type-doc';
                                        $color = 'text-blue-700 bg-blue-50 border-blue-100';
                                    } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                        $icon = 'ti-file-type-ppt';
                                        $color = 'text-orange-500 bg-orange-50 border-orange-100';
                                    } elseif (in_array($ext, ['zip', 'rar'])) {
                                        $icon = 'ti-file-zip';
                                        $color = 'text-yellow-600 bg-yellow-50 border-yellow-100';
                                    } else {
                                        $icon = 'ti-file';
                                        $color = 'text-gray-500 bg-gray-50 border-gray-200';
                                    }
                                ?>
                                    <a href="<?= base_url($file['file_path']) ?>" target="_blank"
                                        class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition group">
                                        <div class="w-9 h-9 rounded-lg border flex items-center justify-center shrink-0 <?= $color ?>">
                                            <i class="ti <?= $icon ?> text-lg"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate">
                                                <?= htmlspecialchars($file['file_name']) ?>
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                <?= date('M d, Y g:i A', strtotime($file['uploaded_at'])) ?>
                                            </p>
                                        </div>
                                        <i class="ti ti-download text-gray-300 group-hover:text-gray-500 transition text-base shrink-0"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="p-6 flex flex-col gap-4">

                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">
                            Comments (<?= count($comments) ?>)
                        </h2>
                    </div>

                    <form action="<?= base_url('tickets/comment/' . $tckt_details['id']) ?>" method="POST">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                            value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="flex flex-col gap-2">
                            <textarea name="comment_body" rows="3" placeholder="Write a comment..."
                                class="w-full text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl p-3 resize-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition"></textarea>
                            <button type="submit"
                                class="self-end inline-flex items-center gap-1.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg transition">
                                <i class="ti ti-send text-base"></i> Post comment
                            </button>
                        </div>
                    </form>

                    <hr class="border-gray-100" />

                    <div class="flex flex-col gap-3 overflow-y-auto max-h-[520px] pr-1">
                        <?php if (empty($comments)): ?>
                            <div class="flex flex-col items-center justify-center py-14 border border-dashed border-gray-200 rounded-xl gap-3 text-center">
                                <span class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full">
                                    <i class="ti ti-message-circle-off text-2xl text-gray-400"></i>
                                </span>
                                <p class="text-sm font-medium text-gray-500">No comments yet</p>
                                <p class="text-xs text-gray-400">Be the first to leave one.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="flex gap-3 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center shrink-0 uppercase">
                                        <?= substr($comment['commenter_fullname'] ?? '?', 0, 1) ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <span class="text-xs font-semibold text-gray-700">
                                                <?= htmlspecialchars($comment['commenter_fullname'] ?? 'Unknown') ?>
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                <?= date('M d, Y g:i A', strtotime($comment['comment_at'])) ?>
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            <?= htmlspecialchars($comment['comment_body']) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
                </div>
            </div>
    </main>


    <div id="ReassignModal" style="display:none;"
        class="absolute top-1 left-1/2 transform -translate-x-1/2 translate-y-1/2 z-40 w-full max-w-md">

        <div class="bg-white rounded-2xl border border-slate-200">

            <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Re-Assign ticket</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span id="reassign-modal-code"
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        </span>
                        <span id="reassign-modal-priority" class="text-xs text-slate-400"></span>
                        <span id="reassign-modal-status" class="text-xs text-slate-400"></span>
                    </div>
                </div>
                <button id="re_assign_backbutton"
                    class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" /><path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <form id="reassignForm" method="POST">

                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">
                        Select Department
                    </p>
                    <div class="relative">
                        <i class="ti ti-building absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none"></i>
                        <select name="department" id="department"
                            class="w-full pl-9 pr-8 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg appearance-none cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition">
                            <option value="" selected disabled>Select department</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>"
                                    <?= $dept['id'] == $tckt_details['department_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['dept_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>
                </div>

                <!-- <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">
                        Select Employee
                    </p>
                     <div class="border border-gray-200 rounded-lg text-sm">
                            <!-- <select name="employee" id="assign-employee-dropdown" class="w-full p-2 rounded-lg">
                                <option value="" selected>Select Employee (PIC's)</option>
                            </select> 
                        <div id="re-assign-employee-dropdown" class="p-2">
                            //checkbox is in here 
                        </div>
                        
                    </div>
                </div> -->

                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="re_assign_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15   " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2"><path d="M10 12h4"/><path d="M10 8h4"/><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/></svg>
                        Re-Assign Department
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- //assign modal -->
    <div id="assignModal" style="display:none;"
        class="absolute top-1    left-1/2 transform -translate-x-1/2 translate-y-1/2 z-40 w-full max-w-md">

        <div class="bg-white rounded-2xl border border-slate-200">

            <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Assign ticket</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span id="assign-modal-code"
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        </span>
                        <span id="assign-modal-priority" class="text-xs text-slate-400"></span>
                        <span id="assign-modal-status" class="text-xs text-slate-400"></span>
                        <span id="assign-modal-departmentName" class="text-xs text-slate-400"></span>
                    </div>
                </div>
                <button id="assignback_button"
                    class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" /><path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <form id="assignForm" method="POST">

                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">
                       Department Assigned
                    </p>
                    <div class="text-sm">
                       <p id="employeeModalDisplay" class="font-medium uppercase"></p>
                       <input type="hidden" id="assign-department-id" name="department_id" value="">
                       </div>
                </div>

                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">
                        Select Employee
                    </p>
                    <div class="border border-gray-200 rounded-lg text-sm">
                            <!-- <select name="employee" id="assign-employee-dropdown" class="w-full p-2 rounded-lg">
                                <option value="" selected>Select Employee (PIC's)</option>
                            </select> -->
                        <div id="assign-employee-dropdown" class="p-2">
                            <!-- //checkbox is in here -->
                        </div>
                        
                    </div>
                </div>

                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="assign_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 11 2 2 4-4" />
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        Assign Employee
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script src="<?php echo base_url('assets/JavaScript/getEmployeeAjax.js') ?>"></script>

    <script>
        // ── Elements ──
        const _reAssignBtn   = document.getElementById('ReassignEmpBtn');
        const _assignEmpBtn  = document.getElementById('AssignEmployeeBtn');

        const reAssignModal  = document.getElementById('ReassignModal');
        const AssignModal    = document.getElementById('assignModal');
        const tabledata      = document.getElementById('tabledata');

        const reAssignBackBtn   = document.getElementById('re_assign_backbutton');
        const reAssignCancelBtn = document.getElementById('re_assign_cancel');

        const assignBackBtn     = document.getElementById('assignback_button');
        const assignCancelBtn   = document.getElementById('assign_cancel');
        
        const span_employee  = document.getElementById('assigned_employees');

        // ── Show/Hide logic based on assignment status ──
        // if (span_employee.textContent.trim() === 'Not assigned yet') {
        //     _reAssignBtn.style.display = 'none';
        // } else {
        //     _assignEmpBtn.style.display = 'none';
        // }

        // ── Re-Assign Modal ──
       _reAssignBtn.addEventListener('click', function () {
            const ticket_id = this.getAttribute('data-ticketid');
            document.getElementById('reassignForm').action = BASE_URL + 'tickets/reassign/' + ticket_id; 
            document.getElementById('reassign-modal-code').textContent     = this.getAttribute('data-tcktCode');
            document.getElementById('reassign-modal-priority').textContent = this.getAttribute('data-priority');
            document.getElementById('reassign-modal-status').textContent   = this.getAttribute('data-status');
            reAssignModal.style.display = 'block';
            tabledata.classList.add('blur-sm');
        });


        reAssignBackBtn.addEventListener('click', function () {
            reAssignModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });

        reAssignCancelBtn.addEventListener('click', function () {
            reAssignModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });

        // ── Assign Modal ──
        _assignEmpBtn.addEventListener('click', function () {
            const ticket_id = this.getAttribute('data-ticketid'); 
            // FIXED: Set the form action dynamically so submission handles the correct record
            document.getElementById('assignForm').action = BASE_URL + 'tickets/assign/' + ticket_id; 
            
            document.getElementById('assign-modal-code').textContent     = this.getAttribute('data-tcktCode');
            document.getElementById('assign-modal-priority').textContent = this.getAttribute('data-priority');
            document.getElementById('assign-modal-status').textContent   = this.getAttribute('data-status');
            AssignModal.style.display = 'block';
            tabledata.classList.add('blur-sm');
        });

        assignBackBtn.addEventListener('click', function () {
            AssignModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });

        assignCancelBtn.addEventListener('click', function () {
            AssignModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });
    </script>

</body>
</html>