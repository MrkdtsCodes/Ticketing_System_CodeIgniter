<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refactored tickets table</title>
</head>

<body class="bg-slate-50 p-5">
    <main class="relative pt-20 px-4 min-h-screen">

        <div class="mb-4 flex w-full flex-row-reverse justify-between items-center gap-4 bg-white rounded-lg">
            <table id="myTable" class="w-full border-separate border-spacing-y-1">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3 text-center font-semibold">Ticket Age</th>
                        <th class="px-4 py-3 text-center font-semibold">Ticket No.</th>
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
                <tbody>
                    <?php foreach ($tickets as $createdTickets): ?>
                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $createdTickets['Ticket_Age'] ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center"><?php echo $createdTickets['id'] ?>
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

                        </tr>



                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>

    </main>





</body>

</html>