
$(document).ready(function(){

    $('#approveButton').click(function(){

        let departments = $(this).data('departments');
        // this -> button yung data ng button mo na departments data->departments

        $('#approveModal').load(
            '<?= base_url("tickets/getEmployees/") ?>' + departments
        );

    });

    // use this:
    $(document).on('change', '#department', function(){ 
        let dept_id = $(this).val();
        $.ajax({
                url: BASE_URL + 'tickets/Reassign/getemployees/' + dept_id,
                type: "GET",
                dataType: "JSON",
                success:function(data) {
                    let html = "";

                    data.forEach(function(emp) {
                        html += `<option value="${emp.employee_id}">${emp.employee_fullname}</option>`;
                    });

                    $("#reassign-employee-dropdown").html(html);
             }
        });
    });

    //get data attribbuttes of the "Assign Employee" button 

    $('#AssignEmployeeBtn').click(function(){

        const departmentID = this.getAttribute('data-departmentID');
        const departmentName = this.getAttribute('data-departmentsName');
        

        $('#employeeModalDisplay').text(departmentName);
        $('#assign-department-id').val(departmentID);
         //load the employee name base on the current department
          $.ajax({
            url: BASE_URL + 'tickets/Reassign/getemployees/' + departmentID,
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                    let html = "";

                    data.forEach(function(emp) {
                        html += `<option value="${emp.employee_id}">${emp.employee_fullname}</option>`;
                    });

                    $("#assign-employee-dropdown").html(html);
             }
        })
    });
   


});