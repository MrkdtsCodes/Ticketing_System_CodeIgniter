<div class="p-6 w-full overflow-x-auto rounded-sm border border-gray-200 bg-white shadow-sm">

    <table class="min-w-full text-sm text-left text-gray-700">

        <!-- Table Header -->
        <thead class="sticky top-0 bg-gray-200 text-xs uppercase tracking-wider text-gray-600">
            <tr>
                <th class="px-5 py-4">Ticket Code</th>
                <th class="px-5 py-4">Title</th>
                <th class="px-5 py-4">Author</th>
                <th class="px-5 py-4">Assigned Employee</th>
                <th class="px-5 py-4">Department</th>
                <th class="px-5 py-4">Status</th>
                <th class="px-5 py-4">Priority</th>
                <th class="px-5 py-4">Created At</th>
                <th class="px-5 py-4">Updated At</th>
                <th class="px-5 py-4 text-center">Actions</th>
            </tr>
        </thead>

        <!-- Table Body -->
        <tbody class="divide-y divide-gray-200 text-sm">
            <?php $count = 0 ?>
            <?php foreach($crtdTickets as $tickets): ?>
                <?php $count++ ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200">

                    <td class="px-5 py-4 font-semibold text-blue-600">
                        <?= $tickets['ticket_code'] ?>
                    </td>

                    <td class="px-5 py-4">
                        <?= $tickets['title'] ?>
                    </td>

                    <td class="px-5 py-4">
                         <?= $tickets['author_fullname'] ?>
                    </td>

                    <td class="px-5 py-4">
                         <?= $tickets['author_fullname'] ?>
                    </td>

                    <td class="px-5 py-4">
                        <?= $tickets['dept_name'] ?>
                    </td>

                    <td class="px-5 py-4">
                        <?= $tickets['status'] ?>
                    </td>

                    <td class="px-5 py-4">
                        <?= $tickets['priority'] ?>
                    </td>

                    <td class="px-5 py-4 whitespace-nowrap">
                        <?= $tickets['created_at'] ?>
                    </td>

                    <td class="px-5 py-4 whitespace-nowrap">
                        <?= $tickets['updated_at'] ?>
                    </td>

                    <td class="px-5 py-4">
                        <div>
                            <select name="" id="">
                                <option value="" selected disabled>set</option>
                                <option value="">view</option>
                                <option value="">Edit</option>
                                <option value="">Delete</option>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
            
        <tfoot class ="border border-black ">
            <tr class="flex flex-row-reverse">
                <td class="flex flex-row-reverse">
                    <?php if(!empty($links)):?>
                        <div class="">Showing: <?php echo $total_rows; ?> tickets</div>
                        <div class="pagination p-3 ">
                            <?php echo $links; ?>
                        </div>
                    <?php else: ?>
                        <div class="">
                            <span>No links genarted</span>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        </tfoot>

    </table>
   

</div>