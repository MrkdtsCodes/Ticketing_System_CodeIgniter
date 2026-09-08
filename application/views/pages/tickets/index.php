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
</head>

<body class="p-6">
    <nav class="p-4 mb-3 border border-red-300 flex">

        <form id="tickets_filter">

            <div class="flex gap-3">

                <!-- Status -->
                <div>
                    <select name="status" id="status">
                        <option value="" selected disabled>Status</option>
                        <option value="assigned">Assigned</option>
                        <option value="for_approval">For Approval</option>
                        <option value="approved">Approved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <select name="priority" id="priority">
                        <option value="" selected disabled>Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <!-- Assigned Employee -->
                <div>
                    <select name="assigned_employee" id="assigned_employee">
                        <option value="" selected disabled>
                            Assigned Employee
                        </option>
                    </select>
                </div>

                <!-- Filter Button -->
                <button type="submit" id="f_button">
                    Filter
                </button>

            </div>

        </form>

    </nav>

    <div id = "Target">
        <?php $this->load->view('pages/tickets/posts'); ?>
    </div>
</body>

<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function(){
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const form = document.getElementById('tickets_filter')
        $('.limits').click(function (){
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

        $('.pagination').find('[data-ci-pagination-page]').css({
            border: "1px solid black",
            padding: "5px",

        });

         $('.pagination').find('strong').css({
            border: "1px solid green",
            padding: "5px",
            color: 'green'

        })

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