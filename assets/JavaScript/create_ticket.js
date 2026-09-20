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

        if(subject_feild === "" && description_feild === ""){
            $('#error_subject').html("Subject is Required").addClass("text-red-500");
            $('#error_description').html("Description is Required").addClass("text-red-500");
            return
        }

        if(subject_feild === ""){
            $('#error_subject').html("Subject is Required").addClass("text-red-500");
            $('#error_description').html("Description is Required").addClass("text-red-500");
            return
        }

        if(description_feild === ""){
            $('#error_description').html("Description is Required").addClass("text-red-500");
            return
        }
        

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