<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.0/fonts/tabler-icons.min.css" />
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }

        tbody tr {
            transition: background 0.15s;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <main class="pt-20 pb-10 px-6 max-w-7xl mx-auto">

        <!-- PAGE HEADER -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">User Management</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage all system accounts and roles</p>
            </div>
            <button
            id="addUsr_btnn"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-plus-icon lucide-user-plus">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <line x1="19" x2="19" y1="8" y2="14" />
                        <line x1="22" x2="16" y1="11" y2="11" />
                    </svg></span>
                Add User
            </button>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2"><i class="ti ti-users text-base"></i>
                    Total Users</div>
                <p class="text-2xl font-semibold text-gray-800">6</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2"><i class="ti ti-shield text-base"></i>
                    Admins</div>
                <p class="text-2xl font-semibold text-gray-800">2</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2"><i class="ti ti-user text-base"></i>
                    Employees</div>
                <p class="text-2xl font-semibold text-gray-800">4</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2"><i class="ti ti-user-off text-base"></i>
                    Inactive</div>
                <p class="text-2xl font-semibold text-gray-800">2</p>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">

            <!-- TOOLBAR -->
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-4 flex-wrap">
                <h2 class="text-sm font-semibold text-gray-700">All Users</h2>
                <div class="flex items-center gap-2 flex-wrap">

                    <!-- SEARCH -->
                    <div class="relative">
                        <i
                            class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        <input id="searchInput" type="text" placeholder="Search users..."
                            class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-100 transition w-48" />
                    </div>

                    <!-- ROLE FILTER -->
                    <select id="roleFilter"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:border-blue-500 text-gray-600 cursor-pointer">
                        <option value="">All Roles</option>
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                    </select>

                    <!-- STATUS FILTER -->
                    <select id="statusFilter"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:border-blue-500 text-gray-600 cursor-pointer">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>

                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-gray-400 border-b border-gray-100 bg-gray-50">
                            <th class="py-3 px-5 text-left font-semibold">#</th>
                            <th class="py-3 px-5 text-left font-semibold">User</th>
                            <th class="py-3 px-5 text-left font-semibold">Email</th>
                            <th class="py-3 px-5 text-left font-semibold">Department</th>
                            <th class="py-3 px-5 text-left font-semibold">Role</th>
                            <th class="py-3 px-5 text-left font-semibold">Status</th>
                            <th class="py-3 px-5 text-left font-semibold">Joined</th>
                            <th class="py-3 px-5 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="juan dela cruz"
                            data-role="Admin" data-status="Active">
                            <td class="py-3 px-5 text-gray-400 text-xs">1</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        JD</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Juan dela Cruz</p>
                                        <p class="text-xs text-gray-400">@jdelacruz</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">jdelacruz@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">IT</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">Admin</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">Jan 10, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="maria santos"
                            data-role="Employee" data-status="Active">
                            <td class="py-3 px-5 text-gray-400 text-xs">2</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        MS</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Maria Santos</p>
                                        <p class="text-xs text-gray-400">@msantos</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">msantos@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">HR</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Employee</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">Feb 3, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="ramon reyes"
                            data-role="Employee" data-status="Inactive">
                            <td class="py-3 px-5 text-gray-400 text-xs">3</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        RR</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Ramon Reyes</p>
                                        <p class="text-xs text-gray-400">@rreyes</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">rreyes@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">Finance</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Employee</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>Inactive</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">Mar 18, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="ana lim" data-role="Admin"
                            data-status="Active">
                            <td class="py-3 px-5 text-gray-400 text-xs">4</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        AL</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Ana Lim</p>
                                        <p class="text-xs text-gray-400">@alim</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">alim@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">Operations</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">Admin</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">Apr 2, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="ben garcia" data-role="Employee"
                            data-status="Active">
                            <td class="py-3 px-5 text-gray-400 text-xs">5</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        BG</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Ben Garcia</p>
                                        <p class="text-xs text-gray-400">@bgarcia</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">bgarcia@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">Support</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Employee</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">May 7, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50" data-name="clara perez"
                            data-role="Employee" data-status="Inactive">
                            <td class="py-3 px-5 text-gray-400 text-xs">6</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 text-xs font-semibold flex items-center justify-center shrink-0">
                                        CP</div>
                                    <div>
                                        <p class="font-medium text-gray-800">Clara Perez</p>
                                        <p class="text-xs text-gray-400">@cperez</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-500">cperez@company.com</td>
                            <td class="py-3 px-5 text-xs text-gray-500">IT</td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Employee</span>
                            </td>
                            <td class="py-3 px-5"><span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>Inactive</span>
                            </td>
                            <td class="py-3 px-5 text-xs text-gray-400">Jun 14, 2025</td>
                            <td class="py-3 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition"
                                        title="View"><i class="ti ti-eye text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-500 hover:bg-blue-100 transition"
                                        title="Edit"><i class="ti ti-pencil text-sm"></i></button>
                                    <button
                                        class="p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-500 hover:bg-red-100 transition"
                                        title="Delete"><i class="ti ti-trash text-sm"></i></button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <!-- EMPTY STATE -->
                <div id="emptyState" class="hidden py-16 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                        <i class="ti ti-users-off text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500">No users found</p>
                    <p class="text-xs text-gray-400 mt-1">Try adjusting your search or filters</p>
                </div>
            </div>

            <!-- TABLE FOOTER -->
            <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
                <p id="rowCount" class="text-xs text-gray-400">Showing 6 of 6 users</p>
                <button id="resetBtn" class="text-xs text-blue-500 hover:text-blue-700 transition">Reset
                    filters</button>
            </div>

        </div>
    </main>

    <!-- ── CREATE ACCOUNT MODAL ─────────────────────────────────────────────────── -->
    <div id="createAccountModal" style="display:none;"
      class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-slate-900/40 backdrop-blur-sm"
        style="background: rgba(15,23,42,0.45); backdrop-filter: blur(3px);">

        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="ti ti-user-plus text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">Create Account</h2>
                        <p class="text-xs text-gray-400">Fill in the details to add a new user</p>
                    </div>
                </div>
                <button id="closeCreateModal"
                    class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition">
                    <i class="ti ti-x text-sm"></i>
                </button>
            </div>

            <!-- FORM -->
            <form id="createAccountForm" method="POST" action="<?php echo base_url('tickets/create/account')?>">

                <div class="px-6 py-5 space-y-4 max-h-[65vh] overflow-y-auto">

                    <!-- First + Last Name -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                First Name
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="firstname" placeholder="Juan"
                                    class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                    <small class="text-red-500"><?= form_error('firstname') ?></small>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Last Name
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="lastname" placeholder="dela Cruz"
                                    class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                    <small class="text-red-500"><?= form_error('lastname') ?></small>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Name + Birthdate -->
                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Middle Name
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-user-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="middlename" placeholder="Santos"
                                    class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                    <small class="text-red-500"><?= form_error('middlename') ?></small>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Birthdate
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-calendar-event absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="date" name="birthdate"
                                    class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                    <small class="text-red-500"><?= form_error('birthdate') ?></small>
                            </div>
                        </div>

                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                            Address
                        </label>
                        <div class="relative">
                            <i
                                class="ti ti-map-pin absolute left-3 top-3 text-gray-400 text-sm pointer-events-none"></i>
                            <textarea name="address" rows="3" placeholder="Complete address"
                                class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 resize-none focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition"></textarea>
                                <small class="text-red-500"><?= form_error('address') ?></small>
                        </div>
                    </div>

                    <!-- Zipcode -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                            Zip Code
                        </label>
                        <div class="relative">
                            <i
                                class="ti ti-map-2 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                            <input type="text" name="zipcode" placeholder="1000"
                                class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                <small class="text-red-500"><?= form_error('zipcode') ?></small>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <i
                                class="ti ti-mail absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                            <input type="email" name="email" placeholder="juan@company.com"
                                class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                                <small class="text-red-500"><?= form_error('email') ?></small>
                        </div>
                    </div>

                    <!-- Department + Role -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Department
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-building absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <select name="department"
                                    class="w-full pl-8 pr-8 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 appearance-none focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition cursor-pointer text-gray-700">
                                    <option value="" disabled selected>Select Department</option>
                                    <?php foreach($departments as $dept): ?>
                                        <option value="<?=$dept['id'] ?>"><?=$dept['dept_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <i
                                    class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                    <small class="text-red-500"><?= form_error('department') ?></small>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Role
                            </label>
                            <div class="relative">
                                <i
                                    class="ti ti-shield absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <select name="role"
                                    class="w-full pl-8 pr-8 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 appearance-none focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition cursor-pointer text-gray-700">
                                    <?php foreach($roles as $role): ?>
                                        <option value="<?=$role['id'] ?>"><?=$role['role_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-red-500"><?= form_error('role') ?></small>
                               
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <i
                                class="ti ti-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                            <input type="password" id="passwordInput" name="password" placeholder="Min. 8 characters"
                                class="w-full pl-8 pr-9 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i class="ti ti-eye text-sm" id="eyeIcon"></i>
                            </button>
                            <small class="text-red-500"><?= form_error('password') ?></small>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <i
                                class="ti ti-lock-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                            <input type="password" id="confirmPasswordInput" name="confirm_password"
                                placeholder="Re-enter password"
                                class="w-full pl-8 pr-9 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-50 transition" />
                            <button type="button" id="toggleConfirmPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i class="ti ti-eye text-sm" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Warning note -->
                    <div class="flex gap-2 items-start p-3 bg-amber-50 border border-amber-100 rounded-xl">
                        <i class="ti ti-info-circle text-amber-500 text-base shrink-0 mt-0.5"></i>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            The user will receive their login credentials via email. Make sure the email address is
                            correct before submitting.
                        </p>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" id="cancelCreateModal"
                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                        <i class="ti ti-user-plus text-sm"></i>
                        Create Account
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script src="<?php echo base_url('assets/JavaScript/accountTable.js') ?>"></script>

</body>

</html>