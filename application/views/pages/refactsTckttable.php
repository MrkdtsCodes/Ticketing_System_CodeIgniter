<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/CSS/refactorTables.css')?>">
    <script> const base_url = '<?php echo base_url(); ?>'</script>
    <title>Refactored tickets table</title>
</head>

<body class="bg-slate-50 p-5">
    <main class="relative pt-20 px-4 min-h-screen">

        <div class="mb-4 p-2 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg">

            <!-- RIGHT: export + search -->
            <div class="dt-search-wrapper flex items-center gap-3 flex-row">
                <div class="relative group order-1">
                    <div id="filterbtn" class="filterbtn flex items-center justify-center text-white bg-blue-500 p-3 rounded-lg cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/>
                        </svg>
                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap pointer-events-none">Filter Data</span>
                    </div>
                </div>
                <button id="exportExcelBtn" class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-green-500 flex flex-row items-center gap-2 hover:bg-green-600 transition">Export Excel</button>
                <button id="exportPdfBtn"   class="order-1 px-4 py-3 text-white text-sm rounded-lg bg-red-500   flex items-center gap-2 hover:bg-red-600 transition">Export PDF</button>
            </div>

            <!-- LEFT: nav tabs — ALL use data-filter, no hard href -->
            <div class="flex items-center justify-end gap-2 flex-row flex-wrap">
                <button id="refactoredtickts_BTTN" class="nav-tab">Example</button>
                <button class="nav-tab active" data-filter="">All</button>
                <button class="nav-tab" data-filter="For Approval" id="forApproval_tab">For Approval</button>
                <button class="nav-tab" data-filter="Approved">Approved</button>
                <button class="nav-tab" data-filter="Assigned">Assigned</button>
                <button class="nav-tab" data-filter="On Going">On Going</button>
                <button class="nav-tab" data-filter="For Testing">For Testing</button>
                <button class="nav-tab" data-filter="Closed">Closed</button>
            </div>
        </div>

        <!-- FILTER DROPDOWNS -->
        <div id="showFilter" style="display:none" class="mb-4 flex w-full justify-center p-4 border border-black items-center gap-4 bg-white rounded-lg">
            <select id="statusTab" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50">
                <option value="">-- Select Status --</option>
                <option>For Approval</option><option>Approved</option><option>To Assign</option>
                <option>Assigned</option><option>On Going</option><option>For Testing</option>
                <option>Closed</option><option>Rejected</option>
            </select>
            <select id="priority" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50">
                <option value="">-- Select Priority --</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <div class="reset px-6 py-2 rounded-md text-sm font-medium bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-500 hover:text-white transition cursor-pointer">
                <div class="relative group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap pointer-events-none">Reset filter</span>
                </div>
            </div>
        </div>

        <div class="mb-4 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg">
            <table id="myTable" class="w-full border-separate border-spacing-y-1">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-700 bg-slate-200">
                        <th class="px-4 py-3 text-center font-semibold">Ticket Age</th>
                        <th class="px-4 py-3 text-center font-semibold">Ticket CODE</th>
                        <th class="px-4 py-3 text-center font-semibold">Subject</th>
                        <th class="px-4 py-3 text-center font-semibold">Author</th>
                        <!-- <th class="px-4 py-3 text-center font-semibold">PIC(s)</th> -->
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Priority</th>
                        <th class="px-4 py-3 text-center font-semibold">Department</th>
                        <th class="px-4 py-3 text-center font-semibold">Created at</th>
                        <th class="px-4 py-3 text-center font-semibold">Updated at</th>
                        <th class="px-4 py-3 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="tablebody">
                    <?php foreach ($tickets as $createdTickets): ?>
                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">

                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                
                                <div class="border border-gray text-normal" 
                                     style="
                                     background:<?php  
                                     $tcktAge = $createdTickets['Ticket_Age'];

                                     switch($tcktAge){
                                        case($tcktAge > 8):
                                            echo "#FA5C5C";
                                            break;
                                        case($tcktAge >= 4):
                                            echo "#FFE893";
                                            break;
                                        case($tcktAge <= 3):
                                            echo "#A3D78A";
                                            break;
                                     }

                                     ?>;
                                     color:<?php  
                                     $tcktAge = $createdTickets['Ticket_Age'];

                                     switch($tcktAge){
                                        case($tcktAge > 8):
                                            echo "white";
                                            break;
                                        case($tcktAge >= 7):
                                            echo "gray";
                                            break;
                                        case($tcktAge <= 3):
                                            echo "gray";
                                            break;
                                     }

                                     ?>
                                     
                                     ">
                                    <?php echo $createdTickets['Ticket_Age'] ?>
                                </div>

                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700 text-center"><?php echo $createdTickets['ticket_code'] ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center"><?php echo $createdTickets['title'] ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center"><?php echo $createdTickets['author_fullname'] ?>
                            </td>
<!--                             
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $pics ?>
                            </td>s -->
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $createdTickets['status'] ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $createdTickets['priority'] ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $createdTickets['dept_name'] ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                 <?php echo date("M d, Y g:i a" , strtotime($createdTickets['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo date("M d, Y g:i a" , strtotime($createdTickets['updated_at'])) ?>
                            </td>
                            <td class="">
                                <div>
                                    <div class="flex">
                                        <select name="" id=""
                                        class="text-sm p-1">
                                            <option value="" selected disabled>Action</option>
                                        </select>
                                    </div>
                                </div>
                            </td>

                        </tr>



                    <?php endforeach; ?>

                </tbody>

            </table>


        </div>
        
         <div class="">

            <div id="container" class="max-w-60 border p-4 flex flex-row">          
                   <!-- dito yung pagination na ginegenerate ng javascript --!>
            </div>
                            
        
        </div>

    </main>




<script src="<?php echo base_url('assets/JavaScript/tabs_in_refactorTables.js') ?>"></script>
</body>

</html>