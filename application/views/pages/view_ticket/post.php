<main class="p-6 md:p-10 mt-14">

        <div id="tabledata"
            class="relative max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                <div class="flex-1 min-w-0">
                    <h1 class="font-semibold text-gray-800 text-base mb-2"><?= ucfirst($ticket_data['title']) ?></h1>
                    <div class="flex flex-wrap items-center gap-2">

                        <!-- Ticket code -->
                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <i class="ti ti-ticket text-sm"></i>
                            <?= ucfirst($ticket_data['ticket_code']) ?>
                        </span>

                        <!-- Status badge (swap color classes per status)
                             approved:     bg-green-50 text-green-700 border border-green-200
                             on going:     bg-blue-50 text-blue-700 border border-blue-200
                             rejected:     bg-red-50 text-red-700 border border-red-200
                             for approval: bg-amber-50 text-amber-700 border border-amber-200
                             other:        bg-gray-100 text-gray-600 border border-gray-200 -->
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                            <i class="ti ti-clock-check text-sm"></i>
                            <?= ucfirst($ticket_data['status']) ?>
                        </span>

                        <!-- Priority badge (low = green, medium = yellow, high = red) -->
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-red-50 text-red-700 border border-red-200">
                            <i class="ti ti-flag text-sm"></i>
                            <?= ucfirst($ticket_data['priority']) ?>
                        </span>

                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 shrink-0">

                    <!-- Timeline Button -->
                    <button id="tckt_hstry"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="18" r="3" />
                            <circle cx="6" cy="6" r="3" />
                            <circle cx="18" cy="6" r="3" />
                            <path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9" />
                            <path d="M12 12v3" />
                        </svg>
                        <span>Ticket Timeline</span>
                    </button>

                    <!-- Re-Assign Department (hidden by default, shown by JS) -->
                    <button id="ReassignEmpBtn"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 12h4" />
                            <path d="M10 8h4" />
                            <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                            <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" />
                            <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                        </svg>
                        <span>Re-Assign Department</span>
                    </button>

                    <!-- Assign Employee (hidden by default, shown by JS) -->
                    <button id="AssignEmployeeBtn"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition"
                        data-department_id ="<?= $ticket_data['department_id']?>"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>
                        <span>Assign Employee</span>
                    </button>

                    <!-- Re-Assign Employee (hidden by default, shown by JS) -->
                    <button id="re_assignEmployeeBtn"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-lg transition">
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

            <!-- BODY: 2 COLUMNS -->
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">

                <!-- LEFT: Ticket details -->
                <div class="p-6 space-y-6">

                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Ticket Details</h2>

                    <div class="flex flex-wrap gap-2">
                        <span title="Department"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-building text-sm"></i>
                            <?= $ticket_data['department_name']?>
                        </span>
                        <span title="Author"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-user text-sm"></i>
                            Juan Dela Cruz
                        </span>
                        <span id="assigned_employees" title="PIC's"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-full">
                            <i class="ti ti-user-check text-sm"></i>
                            Maria Santos, Pedro Reyes
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Date Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?php
                                    $date_created = new DateTimeImmutable($ticket_data['created_at']);
                                    echo $date_created->format('F j, Y');
                                ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Time Created</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?= $date_created->format('h:i A');?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Last Updated</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?php
                                $date_updated = new DateTimeImmutable($ticket_data['updated_at']);
                                echo $date_updated->format('F j, Y');
                                ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Assigned Date</p>
                            <p class="text-sm font-medium text-gray-700">
                                <?php
                                    $assigned_date = $ticket_data['date_assigned'];
                                    echo (isset($assigned_date)) ? $assigned_date : "Unassigned";
                                ?></p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Ticket Age</p>
                            <p class="text-sm font-medium text-gray-700">3 days</p>
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
                                <?= ucfirst($ticket_data['body']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Attachments (2)</p>
                        <div class="flex flex-col gap-2">

                            <!-- Attachment item (image) -->
                            <a href="#" class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-lg border flex items-center justify-center shrink-0 text-blue-500 bg-blue-50 border-blue-100">
                                    <i class="ti ti-photo text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">aircon-photo.jpg</p>
                                    <p class="text-xs text-gray-400">Oct 11, 2026 9:30 AM</p>
                                </div>
                                <i class="ti ti-download text-gray-300 group-hover:text-gray-500 transition text-base shrink-0"></i>
                            </a>

                            <!-- Attachment item (pdf) -->
                            <a href="#" class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-lg border flex items-center justify-center shrink-0 text-red-500 bg-red-50 border-red-100">
                                    <i class="ti ti-file-type-pdf text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">maintenance-report.pdf</p>
                                    <p class="text-xs text-gray-400">Oct 11, 2026 9:32 AM</p>
                                </div>
                                <i class="ti ti-download text-gray-300 group-hover:text-gray-500 transition text-base shrink-0"></i>
                            </a>

                        </div>
                    </div>

                </div>

                <!-- RIGHT: Comments -->
                <div class="p-6 flex flex-col gap-4">

                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Comments (2)</h2>
                    </div>

                    <form action="#" method="POST">
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

                        <!-- Comment item -->
                        <div class="flex gap-3 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center shrink-0 uppercase">M</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="text-xs font-semibold text-gray-700">Maria Santos</span>
                                    <span class="text-xs text-gray-400">Oct 11, 2026 1:00 PM</span>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">I'll check the unit this afternoon.</p>
                            </div>
                        </div>

                        <!-- Comment item -->
                        <div class="flex gap-3 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center shrink-0 uppercase">J</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="text-xs font-semibold text-gray-700">Juan Dela Cruz</span>
                                    <span class="text-xs text-gray-400">Oct 11, 2026 1:30 PM</span>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">Thanks, please let me know once it's fixed.</p>
                            </div>
                        </div>

                        <!-- Empty state (shown when there are no comments) -->
                        <div class="hidden flex-col items-center justify-center py-14 border border-dashed border-gray-200 rounded-xl gap-3 text-center">
                            <span class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full">
                                <i class="ti ti-message-circle-off text-2xl text-gray-400"></i>
                            </span>
                            <p class="text-sm font-medium text-gray-500">No comments yet</p>
                            <p class="text-xs text-gray-400">Be the first to leave one.</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ACTION BUTTON PANEL -->
            <div class="startworkingbtn border border-gray-200 m-4 p-4 rounded-xl flex flex-row-reverse items-center justify-between gap-3 bg-gray-50/50">

                <div class="flex flex-row-reverse gap-3 items-center">

                    <!-- ADMIN: Move to Closed -->
                    <a href="#">
                        <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-medium">
                            <button class="flex flex-row items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8L22 12L18 16" /><path d="M2 12H22" /></svg>
                                Move to Closed
                            </button>
                        </div>
                    </a>

                    <!-- ADMIN: Move to On-going -->
                    <a href="#">
                        <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-medium">
                            <button class="flex flex-row items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8L2 12L6 16" /><path d="M2 12H22" /></svg>
                                Move to On-going
                            </button>
                        </div>
                    </a>

                    <!-- EMPLOYEE: Start working -->
                    <a href="#">
                        <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm text-black bg-yellow-300 hover:bg-yellow-400 font-semibold shadow-sm">
                            <button class="flex flex-row items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z" /></svg>
                                Start working
                            </button>
                        </div>
                    </a>

                    <!-- EMPLOYEE: Submit for Testing -->
                    <a href="#">
                        <div class="py-2 px-[25px] rounded-[10px] border border-black text-sm bg-yellow-500 hover:bg-yellow-600 text-white font-medium shadow-sm">
                            <button class="flex flex-row items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" /><path d="m21.854 2.147-10.94 10.939" /></svg>
                                Submit for Testing
                            </button>
                        </div>
                    </a>

                    <!-- Terminal state badge (closed / rejected) -->
                    <span class="text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-1.5">
                        <i class="ti ti-lock text-base"></i> This ticket is closed
                    </span>

                </div>

                <div class="hidden sm:block">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Current Workflow Stage</span>
                    <span class="text-sm font-bold text-gray-700 capitalize">
                        <?=$ticket_data['status'] ?>
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
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">TKT-0001</span>
                        <span id="reassign-modal-priority" class="text-xs text-slate-400"></span>
                        <span id="reassign-modal-status" class="text-xs text-slate-400">Approved</span>
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
                            <option value="" disabled>Select department</option>
                            <option value="1" selected>Facilities</option>
                            <option value="2">IT</option>
                            <option value="3">HR</option>
                        </select>
                        <i class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" id="re_assign_cancel"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">Cancel</button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 12h4" /><path d="M10 8h4" /><path d="M14 21v-3a2 2 0 0 0-4 0v3" /><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" /><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" /></svg>
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
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full"><?= ucfirst($ticket_data['ticket_code']) ?></span>
                        <span id="assign-modal-priority" class="text-xs text-slate-400"><?= ucfirst($ticket_data['priority']) ?></span>
                        <span id="assign-modal-status" class="text-xs text-slate-400"><?= ucfirst($ticket_data['status']) ?></span>
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
                        <p id="employeeModalDisplay" class="font-medium uppercase"><?= ucfirst($ticket_data['department_name']) ?></p>
                        <input type="hidden" id="assign-department-id" name="department_id" value="">
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Employee</p>
                    <div class="border border-gray-200 rounded-lg text-sm">
                        <div id="assign-employee-dropdown" class="p-2">
                            <!-- checkboxes injected here -->
                            <label class="flex items-center gap-2 p-1"><input type="checkbox"> Maria Santos</label>
                            <label class="flex items-center gap-2 p-1"><input type="checkbox"> Pedro Reyes</label>
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
                            class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">TKT-0001</span>
                        <span id="re_assign-modal-priority" class="text-xs text-slate-400">High</span>
                        <span id="re_assign-modal-status" class="text-xs text-slate-400">Approved</span>
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
                        <p id="re_employeeModalDisplay" class="font-medium uppercase">Facilities</p>
                        <input type="hidden" id="re_assign-department-id" name="department_id" value="">
                    </div>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Employee</p>
                    <div class="border border-gray-200 rounded-lg text-sm">
                        <div id="re_assign-employee-dropdown" class="p-2">
                            <!-- checkboxes injected here -->
                            <label class="flex items-center gap-2 p-1"><input type="checkbox" checked> Maria Santos</label>
                            <label class="flex items-center gap-2 p-1"><input type="checkbox"> Pedro Reyes</label>
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


    <!-- TICKET HISTORY TIMELINE MODAL -->
    <div id="timelineModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" style="display:none;">
        <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-slate-800 mb-1">Ticket History Logs</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span id="modal-ticket-code" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">TKT-0001</span>
                        <span id="modal-ticket-title" class="text-xs text-slate-400 truncate max-w-[250px]">Broken aircon in 3rd floor</span>
                    </div>
                </div>
                <button id="close-timeline-btn" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 transition text-slate-500">
                    <i class="ti ti-x" style="font-size:14px;"></i>
                </button>
            </div>
            <div class="px-5 py-5 max-h-[420px] overflow-y-auto">
                <ol id="timeline-list" class="relative border-l border-slate-150 ml-4 space-y-6">
                    <!-- Loaded dynamically via AJAX -->
                    <li class="ml-4 text-sm text-slate-600">Ticket created — Oct 11, 2026 9:30 AM</li>
                    <li class="ml-4 text-sm text-slate-600">Approved by Admin — Oct 11, 2026 11:00 AM</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Preview only: click a button to open its modal, click X / Cancel to close. Delete this when you wire up your real JS. -->
    <script>
        const pairs = {
            tckt_hstry: 'timelineModal',
            ReassignEmpBtn: 'ReassignModal',
            AssignEmployeeBtn: 'assignModal',
            re_assignEmployeeBtn: 'reassignEmpModal'
        };
        Object.entries(pairs).forEach(([btn, modal]) => {
            document.getElementById(btn).addEventListener('click', () => {
                document.getElementById(modal).style.display = 'flex';
            });
        });
        [
            ['close-timeline-btn', 'timelineModal'],
            ['re_assign_backbutton', 'ReassignModal'], ['re_assign_cancel', 'ReassignModal'],
            ['assignback_button', 'assignModal'], ['assign_cancel', 'assignModal'],
            ['re_assignEmp_backbutton', 'reassignEmpModal'], ['re_assignEmp_cancel', 'reassignEmpModal']
        ].forEach(([btn, modal]) => {
            document.getElementById(btn).addEventListener('click', e => {
                e.preventDefault();
                document.getElementById(modal).style.display = 'none';
            });
        });
    </script>
    <script src="<?= base_url('/assets/JavaScript/compiled/view_tickets.js')?>"></script>
