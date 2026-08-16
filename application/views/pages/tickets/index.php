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
    <nav class="p-4 mb-3 border border-red-300 flex "> 
        <form action="" class="" data-limit="" data-order_by="">
         
        </form>
            <div>
                <button class="border border-blue-500 px-4" data-order_by="forapproval">For Approval</button>
                <button class="border border-blue-500 px-4" >Approved</button>
                <button class="border border-blue-500 px-4" >Assigned</button>
                <button class="border border-blue-500 px-4" >On-going</button>
            </div>
        <div class="all_btn_tab">
            <button class="limits border border-blue-500 px-4" data-limit="0">All</button>
        </div>

        <div>
            <button class="limits border border-blue-500 px-4" data-limit="10">limit</button>
        </div>
    </nav>

    <div id = "Target">
        <?php $this->load->view('pages/tickets/posts'); ?>
    </div>
</body>

<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function(){
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';

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
    
    });
</script>