$(function(){
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';

    let Selected_id = [];
    
    $(document).on('change', 'select[name="ticket_list"]', function(e){
        const action = $(this).val();
        const ticketId = $(this).data('tckt_id');

        const ticketcode = $(this).data('tckt_code');
        const ticket_author = $(this).data('author_name');
        
        if (action === 'view') {
            window.location.href = base_url + 'ticket/view/' + ticketId; 
        }

        if (action  === "approved"){ 
            let modal = $('#approveModal');
            modal.attr('data-active-ticket', ticketId);
            $('#modal-code').html(ticketcode);
            $('#modal-author').html(ticket_author);

            modal.css("display", "block");
            $('.tickets_table_list').addClass('blur-sm ');
            console.log("The ticket id is: ",ticketId);
        }

        // if(action === "rejected"){
        //     //set up ajax call 
        //     $.ajax({
        //         url: ,
        //         type:,
        //         dataType: 'obj',
        //         data: ,
        //         success: function(){

        //         }, error: function(){
        //             console.error("The Error is: ",error);
        //         }
        //     })
        //     // return the message

        // }
    });

    $('#approveModal').on("submit", function(e){
        e.preventDefault();
        let ticketId = $(this).attr('data-active-ticket');
        let priority = $('#approveForm input[name="modal_priority"]:checked').val();
        console.log(ticketId);

        $.ajax({
            url: base_url + "approved/ticket",
            type: "POST",
            data: {
                ticket_status: "approved",
                ticket_id: ticketId,
                ticket_priority: priority
            },

            success: function(response) {

                console.log("Server response:", response);
               alert(response.message);

                // dito pwede mong isara ang modal
                $('#approveModal').css("display", "none");

                // then reload page
                window.location.href = base_url + "ticket/view/" + ticketId;
                
            },

            error: function(error) {
                console.error("Error:", error);
            }
        });
    });

    $('#backbutton, #cancelApprove').on('click', function() {
        let modal = $('#approveModal');

        const activeTicketId = modal.attr('data-active-ticket');

        $(`select[data-tckt_id="${activeTicketId}"]`).val('');
        approveModal.style.display = 'none';
        $('.tickets_table_list').removeClass('blur-sm');
    });
});