$(function(){
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';

    let action_dropdown = $('#ticket_list');

    action_dropdown.on('change', function(e){
        const selectedValue = $(this).val();
        const ticketId = action_dropdown.attr('data-tckt_id');
        console.log(ticketId)
        console.log("Action selected:", selectedValue);
        if (selectedValue) {
            $.ajax({
                url: base_url + "ticket/" + selectedValue + "/" + ticketId,
                method: 'GET',
                success: function(response) {
                    console.log('AJAX call successful!');
                    console.log('Server response:', response);

                    $('#Target').html(response);


                },
                error: function(xhr, status, error) {
                    console.error('AJAX call failed:', error);
                }
            });
        }
    });
});