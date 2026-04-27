<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.2/themes/base/jquery-ui.css">

    <!-- your custom CSS always last -->
    <link rel="stylesheet" href="<?php echo base_url('assets/CSS/DataTables.css') ?>">
</head>

<style>

</style>

<body>

    <main class="pt-20 px-4">
        <div class="border  p-4 border-red-500">
            <div class="navsearch">

            </div>
            <table id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Ticket NO.</th>
                        <th>Subject</th>
                        <th>Author</th>
                        <th>PIC(s)</th>
                        <th>Priority</th>
                        <th>status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?= $ticket['ticket_code'] ?></td>
                            <td><?= $ticket['title'] ?></td>
                            <td><?= $ticket['author_fullname'] ?></td>
                            <td><?= $ticket['pic_fullname'] ?></td>
                            <td><?= $ticket['priority'] ?></td>
                            <td><?= $ticket['status'] ?></td>
                            <td><?= $ticket['created_at'] ?></td>
                            <td><?= $ticket['updated_at'] ?></td>
                            <td>
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" s
                                        fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </main>


    <!-- table -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                order: [
                    [0, 'asc']
                ],
                initComplete: function() {
                    $('.dt-search input').attr('placeholder', 'Keyword');
                },
                responsive: false,
                stateSave: true,
                dom: 'f t<"bottom"l p i>',
                pageLength: 5,
                pagingType: "simple_numbers",
                layout: {
                    topStart: null,
                    topEnd: 'search',
                    top: {
                        start: null,
                        end: null
                    }
                }
            });

            // Move search bar into custom container
            $('.dt-search').append($('.dataTables_filter'));
        });
        $.fn.dataTable.version
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>