<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />

    <style>
        body { font-family: 'DM Sans', sans-serif; }

        /* Pagination look. Lives in CSS so it still applies after the AJAX swap */
        .pagination { display: flex; align-items: center; gap: 4px; }
        .pagination a,
        .pagination strong {
            display: inline-block;
            min-width: 2rem;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            font-size: 0.75rem;
            text-align: center;
            color: #4b5563;
            background: #fff;
        }
        .pagination a:hover { background: #f9fafb; border-color: #d1d5db; }
        .pagination strong {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-gray-50 p-6">

        <nav class="mb-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

            <form id="tickets_filter" class="flex flex-wrap items-end gap-3">

                <!-- Status -->
                <div class="w-full sm:w-48">
                    <label for="status" class="mb-1 block text-xs font-medium uppercase tracking-wider text-gray-500">Status</label>
                    <select name="status" id="status"
                        class="w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 hover:border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        <option value="">All statuses</option>
                        <option value="assigned">Assigned</option>
                        <option value="for_approval">For Approval</option>
                        <option value="approved">Approved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <!-- Priority -->
                <div class="w-full sm:w-48">
                    <label for="priority" class="mb-1 block text-xs font-medium uppercase tracking-wider text-gray-500">Priority</label>
                    <select name="priority" id="priority"
                        class="w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 hover:border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        <option value="">All priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <!-- Assigned Employee -->
                <div class="w-full sm:w-56">
                    <label for="assigned_employee" class="mb-1 block text-xs font-medium uppercase tracking-wider text-gray-500">Assigned employee</label>
                    <select name="assigned_employee" id="assigned_employee"
                        class="w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 hover:border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                        <option value="">All employees</option>
                        <?php if (!empty($employees)): ?>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= $emp['emp_id'] ?>"><?= html_escape($emp['fullname']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Filter Button -->
                <button type="submit" id="f_button"
                    class="rounded-md bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/40">
                    Filter
                </button>

            </form>

        </nav>

        <!-- Table gets swapped in here -->
        <div id="Target">
            <?php $this->load->view('pages/tickets/posts'); ?>
        </div>

 

    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function(){
        const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
        const form = document.getElementById('tickets_filter')

            // Delegated, so it still works on .limits elements that arrive after a swap
            $(document).on('click', '.limits', function (){
                const limit = this.getAttribute('data-limit');
                $.ajax({
                    url: base_url + "filterTicket/" + limit,
                    type:"GET",
                    dataType: "html", // ano yung gusto mong makuhang response
                    // data: {}, // nillagay dito kung ano yung gusto mong ipadala sa server 
                    // contentType: "HTML", //anong response yung ipapadala mo
                    success: function(response){
                        $("#Target").html(response);
                    },error: function(error){
                        console.error("The Error is: ",error);
                    }
                });
            });

            $('#f_button').click(function(e){
                e.preventDefault();

                const formData = new FormData(form);
                const formObjct = Object.fromEntries(formData);
                console.log("JS CONSOLE OBJ",formObjct);

                $.post( base_url +'filterTicket', {formObjct}, function(response){
                    // console.log("this is the response", response);
                    $("#Target").html(response);
                });
                
            });
        
        });
    </script>
</body>

</html>