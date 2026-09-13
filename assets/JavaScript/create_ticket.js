$(function() {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';



    $.ajax({
        url: base_url + "Pages/dsplyDept",
        type:"GET",
        dataType: "json", 
        // data: {}, // nillagay dito kung ano yung gusto mong ipadala sa server 
        // contentType: "HTML", //anong response yung ipapadala mo
        success: function(response){
            console.log(response);

            let optionsHtml = '';
            response.forEach(dept => {
                optionsHtml += `<option id="${dept.id}" value="${dept.dept_name}">${dept.dept_name}</option>`
            }); 
            
            $('#department_dropdown').html(optionsHtml);
            
            },error: function(error){
            console.error("The Error is: ",error);
        }
    });




});