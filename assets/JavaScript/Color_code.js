
        const table = $('#myTable').DataTable({
            order: [
                [0, 'asc']
            ],
            responsive: false,
            stateSave: true,


            dom: 'f t<"bottom"l p i>',

            pageLength: 5,
            pagingType: "simple_numbers",
            language: {
                search: "",
                searchPlaceholder: "Search tickets..."
            },


            buttons: [{
                    extend: 'excel',
                    title: 'Tickets Report',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Tickets Report',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
        });

        // Move search input into custom wrapper
        $('.dt-search-wrapper').append($('.dt-search input'));

        //export buttons
        $('#exportExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        $('#exportPdfBtn').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        // ── Nav filter tabs ─────────────────────────────────────────────
        const STATUS_COL = 4;

        $('.navsearch-tab').on('click', function() {
            // Active styling
            $('.navsearch-tab')
                .removeClass('bg-slate-500 text-white')
                .addClass('bg-slate-100 text-slate-600');
            $(this)
                .removeClass('bg-slate-100 text-slate-600')
                .addClass('bg-slate-500 text-white');

            const filter = $(this).data('filter'); // 

            if (filter === '') {
                // Clear filter — show all rows
                table.column(STATUS_COL).search('').draw();
            } else {
                // Exact-match search on the status text inside .status_badge
                table.column(STATUS_COL).search(filter, false, false).draw();
            }
        });

        $('#filterbtn').on('click', function(){
            $('#showFilter').slideToggle(200);
        });


        const priority_cols = 5;

        $('.prioTab').on('change', function(){
            const filter = $(this).val();

            if(filter === ''){
                table.column(priority_cols).search('').draw();
            }else{
                 table.column(priority_cols).search(filter, false, false).draw();
            }
        });

        $('.reset').on('click', function(){

            $('.navsearch-tab')
                .removeClass('bg-slate-500 text-white')
                .addClass('bg-slate-100 text-slate-600');
            $('#reset_tab')
                .removeClass('bg-slate-100 text-slate-600')
                .addClass('bg-slate-500 text-white');
            $('#priority').val('');
            table.search('').columns().search('').draw();
        });





    
