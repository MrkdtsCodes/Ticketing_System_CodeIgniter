<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Tickets</title>
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

        <form action="<?php echo base_url('tickets/send') ?>" method="POST" enctype="multipart/form-data">
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
                    <h1 class="text-xl font-bold ml-3 text-gray-800">View Ticket</h1>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Subject
                            </label>
                            <input type="text" placeholder="Enter ticket subject..." name="ticket_title"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            <small class="text-red-500"><?php echo form_error('ticket_title') ?></small>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Description
                            </label>
                            <div class=" bg-white overflow-hidden">

                                <div
                                    class="flex items-center flex-wrap gap-1 px-3 py-2 bg-gray-50 border-b border-gray-200 text-gray-600">
                                    <button
                                        class="px-2 py-1 text-sm hover:bg-gray-200 rounded transition-colors">Normal</button>
                                    <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                    <button
                                        class="px-2 py-1 font-bold hover:bg-gray-200 rounded transition-colors">B</button>
                                    <button
                                        class="px-2 py-1 italic hover:bg-gray-200 rounded transition-colors">I</button>
                                    <button
                                        class="px-2 py-1 underline hover:bg-gray-200 rounded transition-colors">U</button>
                                    <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                    <button
                                        class="px-2 py-1 text-sm hover:bg-gray-200 rounded transition-colors">&lt;/&gt;</button>
                                </div>

                                <textarea
                                    class="border border-transparent w-full h-64 p-4 text-sm bg-transparent resize-none outline-none placeholder:text-gray-400"
                                    placeholder="Please describe your issue in detail..." name="ticket_body"></textarea>

                            </div>
                            <small class="text-red-500"><?php echo form_error('ticket_body') ?></small>
                        </div>




                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider"
                                for="small_size">
                                Attachments <span class="italic">(Optional)</span>
                            </label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-medium file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 transition-all"
                                name="userfile[]" type="file" id="fileInput" multiple>
                            <small class="text-red-500"><?php echo form_error('userfile') ?></small>
                            <div id="filePreviewContainer" style="margin-top: 15px;"></div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Department In-Charge
                            </label>
                            <div class="relative">
                                <select name="departments"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 appearance-none text-gray-700 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                                    <option value="" disabled selected>Select Department</option>
                                    <?php foreach ($departments as $departs): ?>
                                        <option value="<?php echo $departs['id'] ?>"><?php echo $departs['dept_name'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <small class="text-red-500"><?php echo form_error('departments') ?></small>
                            </div>
                        </div>

                        <div>
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
                        </div>

                        <div>
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
                        </div>

                        <div class="pt-4 flex flex-col gap-5">
                            <button
                                class="w-full text-white bg-green-500 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-3 transition-colors focus:ring-4 focus:ring-green-500">
                                Submit Ticket
                            </button>

                            <input type="reset"
                                class="w-full text-white text-center bg-red-400 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-3 transition-colors focus:ring-4 focus:ring-green-500"
                                value="Clear">

                        </div>

                    </div>

                </div>
            </div>
        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>

    <script>
        // 1. Grab the input and the container from the HTML
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('filePreviewContainer');

        const profile_dropdown = document.getElementById('profile_dropdown');
        const dropdown_menu = document.getElementById('dropdown_menu');

        profile_dropdown.addEventListener('click', () => {

            dropdown_menu.classList.toggle('hidden');


        });


        // 2. Listen for when the user selects files
        fileInput.addEventListener('change', updatePreviewUI);

        // 3. The function that draws the list on the screen
        function updatePreviewUI() {
            // Clear the container first so we don't double-draw
            previewContainer.innerHTML = '';

            // Loop through all the files currently in the input
            Array.from(fileInput.files).forEach((file, index) => {

                // Create a small box for each file
                const fileBox = document.createElement('div');
                fileBox.style.cssText =
                    "display: flex; align-items: center; margin-bottom: 8px; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; width: fit-content;";

                // Add the file name text
                const fileNameText = document.createElement('span');
                fileNameText.textContent = file.name;
                fileNameText.style.marginRight = "10px";

                // Create the "X" remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'x';
                removeBtn.style.cssText = "border: none; background: none; cursor: pointer; color: red;";

                // 4. What happens when they click 'X'
                removeBtn.onclick = function(event) {
                    event.preventDefault(); // Stop form from submitting if they misclick
                    removeFileFromInput(index); // Run our special removal trick
                };

                // Put the text and button inside the box, and put the box on the screen
                fileBox.appendChild(fileNameText);
                fileBox.appendChild(removeBtn);
                previewContainer.appendChild(fileBox);
            });
        }

        // 5. THE TRICK: How to delete a specific file from an HTML input
        function removeFileFromInput(indexToRemove) {
            // We create a fake "clipboard" called DataTransfer
            const dataTransfer = new DataTransfer();

            // Loop through all original files
            const files = fileInput.files;
            for (let i = 0; i < files.length; i++) {
                // Copy every file to our clipboard EXCEPT the one they clicked 'X' on
                if (i !== indexToRemove) {
                    dataTransfer.items.add(files[i]);
                }
            }

            // Replace the stubborn HTML input files with our updated clipboard files
            fileInput.files = dataTransfer.files;

            // Re-draw the UI to show the file is gone
            updatePreviewUI();
        }
    </script>
</body>



</html>