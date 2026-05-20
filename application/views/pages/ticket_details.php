<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ticket Details</title>

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
        body {
            font-family: 'DM Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <main class="p-6 md:p-10 mt-14">
        <div id="tabledata"
            class="relative max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <?php if ($this->session->flashdata('success')): ?>
                <div
                    class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg flex items-center gap-2">
                    <i class="ti ti-circle-check text-base"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div
                    class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg flex items-center gap-2">
                    <i class="ti ti-alert-circle text-base"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div
                class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                <div class="flex-1 min-w-0">
                    <h1 class="font-semibold text-gray-800 text-base mb-2">
                        <?= strtoupper($tckt_details['title']) ?>
                    </h1>
                    <div class="flex flex-wrap items-center gap-2">

                        <span
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <i class="ti ti-ticket text-sm"></i>
                            <?= $tckt_details['ticket_code'] ?>
                        </span>

                        <?php
                        $status = strtolower(trim($tckt_details['status']));
                        if ($status === 'approved') {
                            $sc = 'bg-green-50 text-green-700 border border-green-200';
                        } elseif ($status === 'on going') {
                            $sc = 'bg-blue-50 text-blue-700 border border-blue-200';
                        } elseif ($status === 'rejected') {
                            $sc = 'bg-red-50 text-red-700 border border-red-200';
                        } elseif ($status === 'for approval') {
                            $sc = 'bg-amber-50 text-amber-700 border border-amber-200';
                        } else {
                            $sc = 'bg-gray-100 text-gray-600 border border-gray-200';
                        }
                        ?>
                        <span
                            class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full <?= $sc ?>">
                            <i class="ti ti-clock-check text-sm"></i>
                            <?= htmlspecialchars(ucfirst(strtolower($tckt_details['status']))) ?>
                        </span>

                        <?php
                        $p = strtolower(trim($tckt_details['priority'] ?? ''));
                        if ($p === 'low') {
                            $pc = 'bg-green-50 text-green-700 border border-green-200';
                        } elseif ($p === 'medium') {
                            $pc = 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                        } elseif ($p === 'high') {
                            $pc = 'bg-red-50 text-red-700 border border-red-200';
                        } else {
                            $pc = 'bg-gray-100 text-gray-500 border border-gray-200';
                        }
                        ?>
                        <?php if (!empty($tckt_details['priority'])): ?>
                            <span
                                class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full <?= $pc ?>">
                                <i class="ti ti-flag text-sm"></i>
                                <?= htmlspecialchars(ucfirst(strtolower($tckt_details['priority']))) ?>
                            </span>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 shrink-0">

                    <!-- Timeline Button -->
                    <button id="tckt_hstry" data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>" data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>" data-status="<?= $tckt_details['status'] ?>"
                        data-departmentID="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-git-fork-icon lucide-git-fork">
                            <circle cx="12" cy="18" r="3" />
                            <circle cx="6" cy="6" r="3" />
                            <circle cx="18" cy="6" r="3" />
                            <path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9" />
                            <path d="M12 12v3" />
                        </svg>
                        <span>Ticket Timeline</span>
                    </button>

                    <!-- Reassign Department -->
                    <button id="ReassignEmpBtn" data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>" data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>" data-status="<?= $tckt_details['status'] ?>"
                        data-departments="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>" style="display:none"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-building2-icon lucide-building-2">
                            <path d="M10 12h4" />
                            <path d="M10 8h4" />
                            <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                            <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" />
                            <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                        </svg>
                        <span>Re-Assign Department</span>
                    </button>

                    <!-- Assign Employee -->
                    <button id="AssignEmployeeBtn" data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>" data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>" data-status="<?= $tckt_details['status'] ?>"
                        data-departmentID="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>"
                        data-employees="<?= $tckt_details['assigned_employees'] ?>" style="display:none"
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

                    <!-- Re-assign Employee -->
                    <button id="re_assignEmployeeBtn" data-ticketid="<?= $tckt_details['id'] ?>"
                        data-title="<?= $tckt_details['title'] ?>" data-tcktCode="<?= $tckt_details['ticket_code'] ?>"
                        data-priority="<?= $tckt_details['priority'] ?>" data-status="<?= $tckt_details['status'] ?>"
                        data-departmentID="<?= $tckt_details['department_id'] ?>"
                        data-departmentsName="<?= $tckt_details['dept_name'] ?>" style="display:none"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>
                        <span>Re-Assign Employee</span>
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
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Date
                                Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('M d, Y', strtotime($tckt_details['created_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Time
                                Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('g:i A', strtotime($tckt_details['created_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Last
                                Updated</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= date('M d, Y g:i A', strtotime($tckt_details['updated_at'])) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">
                                Assigned Date</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= !empty($tckt_details['date_assigned']) ? date('M d, Y', strtotime($tckt_details['date_assigned'])) : 'Not Assigned' ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Ticket Age
                            </p>
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
                        <div
                            class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
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
                                        <div
                                            class="w-9 h-9 rounded-lg border flex items-center justify-center shrink-0 <?= $color ?>">
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
                                        <i
                                            class="ti ti-download text-gray-300 group-hover:text-gray-500 transition text-base shrink-0"></i>
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
                            <div
                                class="flex flex-col items-center justify-center py-14 border border-dashed border-gray-200 rounded-xl gap-3 text-center">
                                <span class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full">
                                    <i class="ti ti-message-circle-off text-2xl text-gray-400"></i>
                                </span>
                                <p class="text-sm font-medium text-gray-500">No comments yet</p>
                                <p class="text-xs text-gray-400">Be the first to leave one.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="flex gap-3 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center shrink-0 uppercase">
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

            <!-- ── REVISED BUTTON PANEL ── -->
            <div class="startworkingbtn border border-gray-200 m-4 p-4 rounded-xl flex flex-row-reverse items-center justify-between gap-3 bg-gray-50/50">
                
                <div class="flex flex-row-reverse gap-3 items-center">
                    <?php 
                    $role = $this->session->userdata('role_name');
                    $currentStatus = strtolower(trim($tckt_details['status']));
                    $hasEmployees = !empty($tckt_details['assigned_employees']);
                    ?>

                    <!-- ADMIN ACTIONS -->
                    <?php if ($role === "Admin"): ?>
                        
                        <!-- 1. Close Ticket (Admin has overriding close power) -->
                        <?php if ($currentStatus !== 'closed' && $currentStatus !== 'rejected'): ?>
                            <a href="<?= base_url('tickets/status/closed/' . $tckt_details['priority'] . "/" . $tckt_details['id']) ?>">
                                <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-medium">
                                    <button class="flex flex-row items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16" /><path d="M2 12H22" /></svg>
                                        Move to Closed
                                    </button>
                                </div>
                            </a>
                        <?php endif; ?>

                        <!-- 2. Ongoing Override (Optional Admin Override to trigger Ongoing) -->
                        <?php if ($currentStatus === 'assigned' || $currentStatus === 'testing'): ?>
                            <a href="<?= base_url('tickets/status/ongoing/' . $tckt_details['priority'] . "/" . $tckt_details['id']) ?>">
                                <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-medium">
                                    <button class="flex flex-row items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon lucide-move-left"><path d="M6 8L2 12L6 16" /><path d="M2 12H22" /></svg>
                                        Move to On-going
                                    </button>
                                </div>
                            </a>
                        <?php endif; ?>

                    <!-- EMPLOYEE ACTIONS -->
                    <?php else: ?>
                        
                        <!-- 1. Start Working (Shown only if ticket is assigned) -->
                        <?php if ($currentStatus === "assigned" && $hasEmployees): ?>
                            <a href="<?= base_url('tickets/status/ongoing/' . $tckt_details['priority'] . "/" . $tckt_details['id']) ?>">
                                <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm text-black bg-yellow-300 hover:bg-yellow-400 font-semibold shadow-sm">
                                    <button class="flex flex-row items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wrench-icon lucide-wrench"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z" /></svg>
                                        Start working
                                    </button>
                                </div>
                            </a>
                        <?php endif; ?>

                        <!-- 2. Submit for Testing (Shown when work is ongoing) -->
                        <?php if ($currentStatus === "on going"): ?>
                            <a href="<?= base_url('tickets/status/fortesting/' . $tckt_details['priority'] . "/" . $tckt_details['id']) ?>">
                                <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-yellow-500 hover:bg-yellow-600 text-white font-medium shadow-sm">
                                    <button class="flex flex-row items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-icon lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" /><path d="m21.854 2.147-10.94 10.939" /></svg>
                                        Submit for Testing
                                    </button>
                                </div>
                            </a>
                        <?php endif; ?>

                    <?php endif; ?>

                    <!-- Terminal State Badge -->
                    <?php if ($currentStatus === 'closed' || $currentStatus === 'rejected'): ?>
                        <span class="text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-1.5">
                            <i class="ti ti-lock text-base"></i> This ticket is closed
                        </span>
                    <?php endif; ?>

                </div>

                <div class="hidden sm:block">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Current Workflow Stage</span>
                    <span class="text-sm font-bold text-gray-700 capitalize">
                        <?= htmlspecialchars(strtolower($tckt_details['status'])) ?>
                    </span>
                </div>
            </div>
        </div>
    </main>


    <!-- DEPARTMENT REASSIGN MODAL -->
    <div id="ReassignModal" style="display:none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl">
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
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <form id="reassignForm" method="POST">
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Department</p>
                    <div class="relative">
                        <i class="ti ti-building absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none"></i>
                        <select name="department" id="department"
                            class="w-full pl-9 pr-8 py-2.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg appearance-none cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition">
                            <option value="" selected disabled>Select department</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $tckt_details['department_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['dept_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="re_assign_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">Cancel</button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2"><path d="M10 12h4" /><path d="M10 8h4" /><path d="M14 21v-3a2 2 0 0 0-4 0v3" /><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" /><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" /></svg>
                        Re-Assign Department
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- EMPLOYEE ASSIGN MODAL -->
    <div id="assignModal" style="display:none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl">
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
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <form id="assignForm" method="POST">
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Department Assigned</p>
                    <div class="text-sm">
                        <p id="employeeModalDisplay" class="font-medium uppercase"></p>
                        <input type="hidden" id="assign-department-id" name="department_id" value="">
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Employee</p>
                    <div class="border border-gray-200 rounded-lg text-sm">
                        <div id="assign-employee-dropdown" class="p-2">
                            <!-- checkboxes injected here -->
                        </div>
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="assign_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">Cancel</button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 11 2 2 4-4" /><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
                        Assign Employee
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- EMPLOYEE REASSIGN MODAL -->
    <div id="reassignEmpModal" style="display:none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl">
            <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Re-Assign Employee</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span id="re_assign-modal-code"
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        </span>
                        <span id="re_assign-modal-priority" class="text-xs text-slate-400"></span>
                        <span id="re_assign-modal-status" class="text-xs text-slate-400"></span>
                    </div>
                </div>
                <button id="re_assignEmp_backbutton"
                    class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <form id="re_assignEmpForm" method="POST">
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Department Assigned</p>
                    <div class="text-sm">
                        <p id="re_employeeModalDisplay" class="font-medium uppercase"></p>
                        <input type="hidden" id="re_assign-department-id" name="department_id" value="">
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Employee</p>
                    <div class="border border-gray-200 rounded-lg text-sm">
                        <div id="re_assign-employee-dropdown" class="p-2">
                            <!-- checkboxes injected here -->
                        </div>
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="re_assignEmp_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">Cancel</button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 11 2 2 4-4" /><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
                        Re-Assign Employee
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- ── REVISED DYNAMIC TICKET HISTORY TIMELINE MODAL ── -->
    <div id="timelineModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" style="display:none;">
        <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-lg overflow-hidden shadow-2xl">
            <!-- HEADER -->
            <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-slate-800 mb-1">Ticket History Logs</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span id="modal-ticket-code" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                        </span>
                        <span id="modal-ticket-title" class="text-xs text-slate-400 truncate max-w-[250px]"></span>
                    </div>
                </div>
                <button id="close-timeline-btn" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition text-slate-500">
                    <i class="ti ti-x" style="font-size:14px;"></i>
                </button>
            </div>

            <!-- BODY / TIMELINE CONTENT -->
            <div class="px-5 py-5 max-h-[420px] overflow-y-auto">
                <ol id="timeline-list" class="relative border-l border-slate-150 ml-4 space-y-6">
                    <!-- Loaded dynamically via AJAX -->
                </ol>
            </div>
        </div>
    </div>


    <script src="<?php echo base_url('assets/JavaScript/getEmployeeAjax.js') ?>"></script>

    <script>
        // ── Elements ──
        const _reAssignDeptBtn = document.getElementById('ReassignEmpBtn');
        const _assignEmpBtn = document.getElementById('AssignEmployeeBtn');
        const _reassignEmpBtn = document.getElementById('re_assignEmployeeBtn');

        const reAssignModal = document.getElementById('ReassignModal');
        const AssignModal = document.getElementById('assignModal');
        const reasignEmpModal = document.getElementById('reassignEmpModal');
        const tabledata = document.getElementById('tabledata');

        const reAssignBackBtn = document.getElementById('re_assign_backbutton');
        const reAssignCancelBtn = document.getElementById('re_assign_cancel');

        const assignBackBtn = document.getElementById('assignback_button');
        const assignCancelBtn = document.getElementById('assign_cancel');

        const span_employee = document.getElementById('assigned_employees');

        const reAssignEmpBackBtn = document.getElementById('re_assignEmp_backbutton');
        const reAssignEmpCancelBtn = document.getElementById('re_assignEmp_cancel');

        // ── Show/Hide Action Buttons logic based on status ──
        const rawStatus = _reAssignDeptBtn.getAttribute('data-status');
        const currentStatus = rawStatus.toLowerCase().trim(); // e.g. "for approval"

        const rawEmployees = document.getElementById('AssignEmployeeBtn').getAttribute('data-employees');
        const isAssigned = rawEmployees && rawEmployees !== 'null' && rawEmployees.trim() !== '';


        const tickethistory_button = document.getElementById('tckt_hstry');



        // Re-Assign Department button rules
        if (currentStatus !== 'for approval' && currentStatus !== 'closed' && currentStatus !== 'rejected') {
            _reAssignDeptBtn.style.display = 'flex';
        } else {
            _reAssignDeptBtn.style.display = 'none';
        }

        // Assign / Re-Assign Employee button rules
        if (currentStatus === 'approved') {
            if (isAssigned) {
                _assignEmpBtn.style.display = 'none';
                _reassignEmpBtn.style.display = 'flex';
            } else {
                _assignEmpBtn.style.display = 'flex';
                _reassignEmpBtn.style.display = 'none';
            }
        } else {
            _assignEmpBtn.style.display = 'none';
            _reassignEmpBtn.style.display = 'none';
        }

        // ── Re-Assign Modal Department ──
        _reAssignDeptBtn.addEventListener('click', function () {
            const ticket_id = this.getAttribute('data-ticketid');
            document.getElementById('reassignForm').action = BASE_URL + 'tickets/reassign/' + ticket_id;
            document.getElementById('reassign-modal-code').textContent = this.getAttribute('data-tcktCode');
            document.getElementById('reassign-modal-priority').textContent = this.getAttribute('data-priority');
            document.getElementById('reassign-modal-status').textContent = this.getAttribute('data-status');
            reAssignModal.style.display = 'flex';
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
            document.getElementById('assignForm').action = BASE_URL + 'tickets/assign/' + ticket_id;
            document.getElementById('assign-modal-code').textContent = this.getAttribute('data-tcktCode');
            document.getElementById('assign-modal-priority').textContent = this.getAttribute('data-priority');
            document.getElementById('assign-modal-status').textContent = this.getAttribute('data-status');
            AssignModal.style.display = 'flex';
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

        // ── Re-Assign Employee Button ──
        _reassignEmpBtn.addEventListener('click', function () {
            const ticket_id = this.getAttribute('data-ticketid');
            const departmentID = this.getAttribute('data-departmentID');
            const departmentName = this.getAttribute('data-departmentsName');
            const currentlyAssigned = this.getAttribute('data-employees') || '';

            document.getElementById('re_assignEmpForm').action = BASE_URL + 'tickets/reassignEmployee/' + ticket_id;
            document.getElementById('re_assign-modal-code').textContent = this.getAttribute('data-tcktCode');
            document.getElementById('re_assign-modal-priority').textContent = this.getAttribute('data-priority');
            document.getElementById('re_assign-modal-status').textContent = this.getAttribute('data-status');
            document.getElementById('re_employeeModalDisplay').textContent = departmentName;
            document.getElementById('re_assign-department-id').value = departmentID;

            reassignEmpModal.style.display = 'flex';
            tabledata.classList.add('blur-sm');

            fetch(BASE_URL + 'tickets/Reassign/getemployees/' + departmentID, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                let html = '';
                data.forEach(emp => {
                    const isChecked = currentlyAssigned.includes(emp.employee_fullname) ? 'checked' : '';
                    html += `
                    <div class="p-2 flex items-center gap-2">
                        <input type="checkbox"
                            id="re_assign_${emp.account_id}"
                            name="employeename[]"
                            value="${emp.account_id}" ${isChecked}>
                        <label for="re_assign_${emp.account_id}">
                            ${emp.employee_fullname}
                        </label>
                    </div>`;
                });
                document.getElementById('re_assign-employee-dropdown').innerHTML = html;
            });
        });

        reAssignEmpBackBtn.addEventListener('click', function () {
            reasignEmpModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });

        reAssignEmpCancelBtn.addEventListener('click', function () {
            reasignEmpModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });


        // ── DYNAMIC TICKET HISTORY TIMELINE LOGIC ──
        const timelineBtn = document.getElementById('tickt');
        const timelineModal = document.getElementById('timelineModal');
        const closeTimelineBtn = document.getElementById('close-timeline-btn');
        const timelineList = document.getElementById('timeline-list');

        timelineBtn.addEventListener('click', function () {
            const ticketId = this.getAttribute('data-ticketid');
            const ticketCode = this.getAttribute('data-tcktCode');
            const ticketTitle = this.getAttribute('data-title');

            // Populate header details
            document.getElementById('modal-ticket-code').textContent = ticketCode;
            document.getElementById('modal-ticket-title').textContent = ticketTitle;

            // Clear previous content & show beautiful loading state
            timelineList.innerHTML = `
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <svg class="animate-spin h-8 w-8 text-blue-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Retrieving history log...</p>
                </div>
            `;

            // Open Modal
            timelineModal.style.display = 'flex';
            tabledata.classList.add('blur-sm');

            // Fetch dynamic logs via AJAX
            fetch(BASE_URL + 'tickets/getHistoryAjax/' + ticketId)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    timelineList.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <span class="w-12 h-12 flex items-center justify-center bg-gray-150 rounded-full mb-3">
                                <i class="ti ti-history-toggle text-2xl text-gray-400"></i>
                            </span>
                            <p class="text-sm font-semibold text-gray-600">No activity history logged yet</p>
                            <p class="text-xs text-gray-400 mt-1">Updates to status, priority, or departments will appear here.</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.forEach((log, index) => {
                    // Styles based on the type of change
                    let iconClass = 'ti-tag';
                    let bgColor = 'bg-slate-50';
                    let iconColor = 'text-slate-600';

                    const fieldName = log.field_changed.toLowerCase().trim();
                    if (fieldName === 'status') {
                        iconClass = 'ti-circle-check';
                        bgColor = 'bg-teal-50';
                        iconColor = 'text-teal-700';
                    } else if (fieldName === 'priority') {
                        iconClass = 'ti-flag';
                        bgColor = 'bg-amber-50';
                        iconColor = 'text-amber-700';
                    } else if (fieldName === 'department_id') {
                        iconClass = 'ti-building';
                        bgColor = 'bg-violet-50';
                        iconColor = 'text-violet-700';
                    }

                    // Parse the raw timestamp into a beautiful display
                    const dateObj = new Date(log.changed_at);
                    const formattedDate = dateObj.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    }) + ', ' + dateObj.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });

                    html += `
                    <li class="flex gap-3 pb-6 relative">
                        <div class="relative z-10 flex-shrink-0">
                            <div class="w-8 h-8 rounded-full ${bgColor} flex items-center justify-center shadow-sm border border-slate-100">
                                <i class="ti ${iconClass} ${iconColor}" style="font-size:16px;"></i>
                            </div>
                            <div class="absolute left-4 top-8 bottom-0 w-px bg-slate-200"></div>
                        </div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-sm font-semibold text-slate-800">${log.changer_name || 'System / Admin'}</span>
                                <span class="text-xs text-slate-400 whitespace-nowrap">${formattedDate}</span>
                            </div>
                            <p class="text-xs text-slate-400 mb-2">
                                Field Modified: <span class="font-mono bg-slate-100 text-slate-600 px-1 py-0.5 rounded text-[10px]">${log.field_changed}</span>
                            </p>
                            <div class="flex items-center gap-2 flex-wrap text-xs">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 border border-slate-200 font-medium">
                                    ${log.old_value ? log.old_value : 'None'}
                                </span>
                                <i class="ti ti-arrow-right text-slate-300" style="font-size:13px;"></i>
                                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-800 border border-blue-200 font-semibold shadow-sm">
                                    ${log.new_value}
                                </span>
                            </div>
                        </div>
                    </li>`;
                });
                
                timelineList.innerHTML = html;
            })
            .catch(err => {
                timelineList.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <i class="ti ti-circle-x text-red-500 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-red-600">Failed to load history logs.</p>
                        <p class="text-xs text-gray-400 mt-1">Please try again later.</p>
                    </div>
                `;
            });
        });

        // Close Modal Listeners
        closeTimelineBtn.addEventListener('click', function () {
            timelineModal.style.display = 'none';
            tabledata.classList.remove('blur-sm');
        });

        timelineModal.addEventListener('click', function (e) {
            if (e.target === timelineModal) {
                timelineModal.style.display = 'none';
                tabledata.classList.remove('blur-sm');
            }
        });

        tickethistory_button.addEventListener('click', function(){
            
            const ticket_id = this.getAttribute('data-ticketid');

            const url = BASE_URL + '' + ticket_id;

            xhr.open('POST', url, true);
            xhr.onload = function(){

            if(this.status == 200){

                const response = JSON.parse(this.responseText);

                

            

                

            }else{
                    console.log("this wont send");
                }
            
            }
            xhr.send();







        });
    </script>
</body>
</html>