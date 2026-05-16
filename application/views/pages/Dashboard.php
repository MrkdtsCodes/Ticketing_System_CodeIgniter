<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ticket Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.0/fonts/tabler-icons.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9999px; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

  

    <main class="pt-20 pb-10 px-6 max-w-7xl mx-auto">

        <!-- PAGE HEADER -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-400 mt-0.5">May 2026 — all departments</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500 bg-white border border-gray-200 px-3 py-2 rounded-lg">
                <i class="ti ti-calendar text-base"></i>
                Last updated: today
            </div>
        </div>

        <!-- METRIC CARDS -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">

            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                    <i class="ti ti-ticket text-base"></i> Total tickets
                </div>
                <p class="text-2xl font-semibold text-gray-800">248</p>
                <p class="text-xs text-green-600 mt-1">↑ 12% this month</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                    <i class="ti ti-clock text-base"></i> For approval
                </div>
                <p class="text-2xl font-semibold text-gray-800">34</p>
                <p class="text-xs text-gray-400 mt-1">Pending review</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                    <i class="ti ti-loader text-base"></i> On going
                </div>
                <p class="text-2xl font-semibold text-gray-800">57</p>
                <p class="text-xs text-green-600 mt-1">↑ 8 this week</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                    <i class="ti ti-circle-check text-base"></i> Resolved
                </div>
                <p class="text-2xl font-semibold text-gray-800">142</p>
                <p class="text-xs text-green-600 mt-1">↑ 23% vs last mo</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center gap-2 text-gray-400 text-xs mb-2">
                    <i class="ti ti-x text-base"></i> Rejected
                </div>
                <p class="text-2xl font-semibold text-gray-800">15</p>
                <p class="text-xs text-red-500 mt-1">↓ 3 this week</p>
            </div>

        </div>

        <!-- CHARTS ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

            <!-- LINE CHART -->
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-gray-700">Tickets over time</h2>
                <p class="text-xs text-gray-400 mb-4">Monthly volume Jan – May 2026</p>
                <div class="flex gap-4 mb-3">
                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="w-3 h-0.5 bg-blue-500 inline-block"></span> Created
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="w-3 h-0.5 bg-emerald-500 inline-block" style="border-top: 2px dashed #10b981; background:none;"></span> Resolved
                    </div>
                </div>
                <div style="position:relative; width:100%; height:220px;">
                    <canvas id="lineChart" role="img" aria-label="Line chart of tickets created vs resolved Jan to May 2026">Created: 40,55,48,62,58. Resolved: 30,42,44,55,52.</canvas>
                </div>
            </div>

            <!-- DOUGHNUT CHART -->
            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-gray-700">Status breakdown</h2>
                <p class="text-xs text-gray-400 mb-4">Current distribution</p>
                <div style="position:relative; width:100%; height:180px;">
                    <canvas id="doughnutChart" role="img" aria-label="Doughnut chart: 57% resolved, 23% ongoing, 14% for approval, 6% rejected">Resolved 57%, On going 23%, For approval 14%, Rejected 6%.</canvas>
                </div>
                <div class="mt-4 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span><span class="text-gray-500">Resolved</span></div>
                        <span class="font-medium text-gray-700">57%</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span><span class="text-gray-500">On going</span></div>
                        <span class="font-medium text-gray-700">23%</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span><span class="text-gray-500">For approval</span></div>
                        <span class="font-medium text-gray-700">14%</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span><span class="text-gray-500">Rejected</span></div>
                        <span class="font-medium text-gray-700">6%</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- RECENT TICKETS -->
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-gray-700 mb-1">Recent tickets</h2>
                <p class="text-xs text-gray-400 mb-4">Latest 5 submissions</p>
                <table class="w-full text-sm" style="table-layout:fixed;">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-2 text-left font-medium w-24">Code</th>
                            <th class="pb-2 text-left font-medium">Subject</th>
                            <th class="pb-2 text-left font-medium w-28">Status</th>
                            <th class="pb-2 text-left font-medium w-20">Priority</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr>
                            <td class="py-2.5 text-xs text-gray-400 font-medium">TCK-00248</td>
                            <td class="py-2.5 text-xs text-gray-700 truncate pr-3">Login page not loading</td>
                            <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">For approval</span></td>
                            <td class="py-2.5"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">High</span></td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-xs text-gray-400 font-medium">TCK-00247</td>
                            <td class="py-2.5 text-xs text-gray-700 truncate pr-3">Export PDF broken</td>
                            <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">On going</span></td>
                            <td class="py-2.5"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Medium</span></td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-xs text-gray-400 font-medium">TCK-00246</td>
                            <td class="py-2.5 text-xs text-gray-700 truncate pr-3">Dashboard not loading data</td>
                            <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Resolved</span></td>
                            <td class="py-2.5"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Low</span></td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-xs text-gray-400 font-medium">TCK-00245</td>
                            <td class="py-2.5 text-xs text-gray-700 truncate pr-3">Email notifications missing</td>
                            <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Rejected</span></td>
                            <td class="py-2.5"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Medium</span></td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-xs text-gray-400 font-medium">TCK-00244</td>
                            <td class="py-2.5 text-xs text-gray-700 truncate pr-3">User cannot reset password</td>
                            <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">On going</span></td>
                            <td class="py-2.5"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">High</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- DEPARTMENT LOAD -->
            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-gray-700 mb-1">Department load</h2>
                <p class="text-xs text-gray-400 mb-4">Open tickets per department</p>
                <div class="flex flex-col gap-3">

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-20 shrink-0">IT</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width:85%;"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">42</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-20 shrink-0">Finance</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width:60%;"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">30</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-20 shrink-0">HR</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width:40%;"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">20</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-20 shrink-0">Operations</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width:30%;"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">15</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 w-20 shrink-0">Support</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width:20%;"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 w-6 text-right">10</span>
                    </div>

                </div>

                <!-- PRIORITY BREAKDOWN -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 mb-3">Priority breakdown</p>
                    <div class="flex gap-2">
                        <div class="flex-1 bg-red-50 border border-red-100 rounded-lg p-3 text-center">
                            <p class="text-lg font-semibold text-red-700">28</p>
                            <p class="text-xs text-red-400 mt-0.5">High</p>
                        </div>
                        <div class="flex-1 bg-amber-50 border border-amber-100 rounded-lg p-3 text-center">
                            <p class="text-lg font-semibold text-amber-700">63</p>
                            <p class="text-xs text-amber-400 mt-0.5">Medium</p>
                        </div>
                        <div class="flex-1 bg-green-50 border border-green-100 rounded-lg p-3 text-center">
                            <p class="text-lg font-semibold text-green-700">157</p>
                            <p class="text-xs text-green-400 mt-0.5">Low</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <script>
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    {
                        label: 'Created',
                        data: [40, 55, 48, 62, 58],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.06)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#3b82f6',
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Resolved',
                        data: [30, 42, 44, 55, 52],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.06)',
                        borderWidth: 2,
                        borderDash: [4, 3],
                        pointRadius: 3,
                        pointBackgroundColor: '#10b981',
                        tension: 0.4,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { color: '#9ca3af', font: { size: 11, family: 'DM Sans' } }
                    },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { color: '#9ca3af', font: { size: 11, family: 'DM Sans' } },
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Resolved', 'On going', 'For approval', 'Rejected'],
                datasets: [{
                    data: [57, 23, 14, 6],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f87171'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { legend: { display: false } }
            }
        });
    </script>

</body>
</html>