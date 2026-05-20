$(document).ready(function () {


    // ASSIGN BUTTON

    $('#AssignEmployeeBtn').click(function () {

        const departmentID = this.getAttribute('data-departmentID');
        const departmentName = this.getAttribute('data-departmentsName');

        $('#employeeModalDisplay').text(departmentName);
        //hidden input
        $('#assign-department-id').val(departmentID);
        // $.post('link',{},function(response){

        // },'json')
        $.ajax({
            url: BASE_URL + 'tickets/Reassign/getemployees/' + departmentID,
            type: "GET",
            dataType: "JSON",

            success: function(response){

                let html = "";

                response.forEach(function(emp){
                    
                    html += `
                        <div class="p-2 flex items-center gap-2">
                            <input type="checkbox"
                                id="assign_${emp.account_id}"
                                name="employeename[]"
                                value="${emp.account_id}">
                            <label for="assign_${emp.account_id}">
                                ${emp.employee_fullname}
                            </label>
                        </div>
                    `;
                    
                   html += `
                    <p>`+emp.employee_fullname+`</p>
                   `;
                });

                $("#assign-employee-dropdown").html(html);
            }
        });
    });


 
    // REASSIGN BUTTON

    // $('#ReassignEmpBtn').click(function () {

    //     const departmentID = this.getAttribute('data-departments');

    //     $.ajax({
    //         url: BASE_URL + 'tickets/Reassign/getemployees/' + departmentID,
    //         type: "GET",
    //         dataType: "JSON",

    //         success: function (data) {

    //             let html = "";

    //             data.forEach(function (emp) {
    //                 html += `
    //                     <div class="p-2 flex items-center gap-2">
    //                         <input type="checkbox"
    //                             id="reassign_${emp.account_id}"
    //                             name="employeename[]"
    //                             value="${emp.account_id}">
    //                         <label for="reassign_${emp.account_id}">
    //                             ${emp.employee_fullname}
    //                         </label>
    //                     </div>
    //                 `;
    //             });

    //             $("#re-assign-employee-dropdown").html(html);
    //         }
    //     });
    // });



    // DEPARTMENT CHANGE 

    $(document).on('change', '#department', function () {

        const dept_id = $(this).val();
        if (!dept_id) return;

        $.ajax({
            url: BASE_URL + 'tickets/Reassign/getemployees/' + dept_id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                let html = "";

                data.forEach(function (emp) {
                    html += `
                        <div class="p-2 flex items-center gap-2">
                            <input type="checkbox"
                                id="reassign_${emp.account_id}"
                                name="employeename[]"
                                value="${emp.account_id}">
                            <label for="reassign_${emp.account_id}">
                                ${emp.employee_fullname}
                            </label>
                        </div>
                    `;
                });

                $("#re-assign-employee-dropdown").html(html);
            }
        });
    });


});


