<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    
    <main class="pt-28 pb-12 px-4">

        <?php if (!empty($error)) : ?>
            <div class="mb-3 flex flex-row justify-center gap-3 max-w-6xl mx-auto bg-white border border-gray-200 rounded-xl p-1 md:p-8 shadow-s text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket-x-icon lucide-ticket-x"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="m9.5 14.5 5-5"/><path d="m9.5 9.5 5 5"/></svg>
                <?= $error ?>
            </div>

        <?php elseif ($this->session->flashdata('success')): ?>
            <div class="mb-3 flex flex-row justify-center gap-3 max-w-6xl mx-auto bg-white border border-gray-200 rounded-xl p-1 md:p-8 shadow-s text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket-check-icon lucide-ticket-check"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="m9 12 2 2 4-4"/></svg>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <form id="create_ticket_form" enctype="multipart/form-data">
            <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-xl p-6 md:p-8 shadow-sm">

                <div class="flex items-center mb-8 border-b border-gray-100 pb-4">
                    <div class="bg-blue-50 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold ml-3 text-gray-800">Create Ticket</h1>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                <span>Subject</span><span class="text-red-500">*</span>
                            </label>
                            <input type="text" placeholder="Enter ticket subject..." name="subject"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            <small id="error_subject"></small>
                        </div>

                        <div class="">
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                <span>Description</span><span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-lg bg-white overflow-hidden">

                                <div
                                    class="flex items-center flex-wrap gap-1 px-3 py-2 bg-gray-50 border-b border-gray-200 text-gray-600">
                                    <span
                                        class="px-2 py-1 text-sm hover:bg-gray-200 rounded transition-colors">Normal</span>
                                    <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                    <span
                                        class="px-2 py-1 font-bold hover:bg-gray-200 rounded transition-colors">B</span>
                                    <span
                                        class="px-2 py-1 italic hover:bg-gray-200 rounded transition-colors">I</span>
                                    <span
                                        class="px-2 py-1 underline hover:bg-gray-200 rounded transition-colors">U</span>
                                    <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                    <span
                                        class="px-2 py-1 text-sm hover:bg-gray-200 rounded transition-colors">&lt;/&gt;</span>
                                </div>

                                <textarea
                                    class="border border-transparent w-full h-64 p-4 text-sm bg-transparent resize-none outline-none placeholder:text-gray-400"
                                    placeholder="Please describe your issue in detail..." name="description"></textarea>
                            </div>
                            <small id="error_description"></small>
                        </div>




                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider"
                                for="small_size">
                                Attachments <span class="italic">(Optional)</span>
                            </label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-medium file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 transition-all"
                                name="attachment[]" type="file" id="fileInput" multiple>
                            <small class="text-red-500"><?php echo form_error('userfile') ?></small>
                            <div id="filePreviewContainer" style="margin-top: 15px;"></div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                <span>Department In-Charge</span><span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="department" id="department_dropdown"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                                </select>
                                <small class="text-red-500" id="error_description"></small>
                            </div>
                        </div>

                        <!-- <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Ticket Priority
                            </label>
                            <div class="relative">
                                <select name="priority"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                                    <option value="" disabled selected>Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                                <small class="text-red-500"><?php echo form_error('priority') ?></small>
                            </div>
                        </div> -->

                        <!-- <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Ticket status
                            </label>
                            <div class="relative">
                                <select name="status"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                                    <option value="" disabled selected>To Assign</option>
                                    <option value="low" disabled>Open</option>
                                    <option value="medium" disabled>Ongoing</option>
                                    <option value="high" disabled>High</option>
                                    <option value="urgent" disabled>Urgent</option>
                                </select>

                            </div>
                        </div> -->

                        <div class="pt-4 flex flex-col gap-5">
                            <input
                                class="w-full text-white bg-green-400 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-3 transition-colors focus:ring-4 focus:ring-green-500"
                                type="submit" id="create_ticket_form"
                            >

                            <input type="reset"
                                class="w-full text-white text-center bg-red-400 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-3 transition-colors focus:ring-4 focus:ring-red-500"
                                value="Clear">
                        </div>

                    </div>

                </div>
            </div>
        </form>

    </main>
</body>

<script src="../assets/JavaScript/jquery-4.0.0.min.js"></script>
<script src="../assets/JavaScript/create_ticket.js"></script>