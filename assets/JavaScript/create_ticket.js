$(function() {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';

    //getting the department dropdown options
    $.ajax({
        url: base_url + "Pages/dsplyDept",
        type:"GET",
        dataType: "json", 
        // data: {}, // nillagay dito kung ano yung gusto mong ipadala sa server 
        // contentType: "HTML", //anong response yung ipapadala mo
        success: function(response){
            console.log(response);

            let optionsHtml = '<option value="" disabled selected>Select Department</option>';

            $('#department_dropdown')
                .html(`<option disabled selected>Select Department</option`);

            response.forEach(dept => {
                optionsHtml += `<option id="${dept.id}" value="${dept.id}">${dept.dept_name}</option>`
            }); 
            
            $('#department_dropdown').html(optionsHtml);
            },error: function(error){
            console.error("The Error is: ",error);
        }
    });

    $( "#create_ticket_form" ).on( "submit", function( event ) {
        event.preventDefault();

        const form = $('#create_ticket_form')[0];
        const formdata = new FormData(form);

        const subject_feild = $("[name='subject']").val().trim();
        const description_feild = $("[name='description']").val().trim();

        let isValid = true;              // start by assuming everything is fine

        if (subject === "") {
            $('#error_subject').text("Subject is required");
            isValid = false;             // problem found, remember it
        }

        if (description === "") {
            $('#error_description').text("Description is required");
            isValid = false;
        }

        if (!dept) {
            $('#error_department').text("Please select a department");
            isValid = false;
        }

        if (!isValid) return;      

        fetch(
        base_url + 'ticket/creation',
        {
            method: 'POST',
            //headers: {'Content-Type': 'application/json'},
            body: formdata
        }
        )
        .then(response => {
            console.log("DATA RECEIVED");  
            return response.text()})
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error(error);
        });
    });
});