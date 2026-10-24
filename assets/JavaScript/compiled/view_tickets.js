"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn = document.getElementById('AssignEmployeeBtn');
    const department_id = assign_btn ? assign_btn.getAttribute('data-department_id') : null;
    const form = document.getElementById('assignForm');
    //get employee after the pages loads
    get_Employee();
    form?.addEventListener('submit', function (e) {
        e.preventDefault();
        const employee_container = document.getElementById('assign-employee-dropdown');
        if (!employee_container)
            return;
        const checked = employee_container.querySelectorAll('input[type="checkbox"]:checked');
        const emp_ids = Array.from(checked).map(cb => cb.value);
        assign_employee(emp_ids);
    });
    function assign_employee(emp_ids = []) {
        if (emp_ids.length == 0) {
            alert("You must choose 1 or More Employees");
        }
    }
    async function get_Employee() {
        let response = await fetch(base_url + 'tickets/Reassign/getemployees/' + department_id);
        let text = await response.json();
        console.table(text);
        let html = '';
        text.forEach(element => {
            html += `
                <label class="flex items-center gap-2 p-1 cursor-pointer">
                    <input type="checkbox" name="employee_ids[]" value="${element.account_id}"
                        data-employee_id="${element.account_id}"
                        data-employee_name="${element.employee_fullname}">
                    ${element.employee_fullname}
                </label>
            `;
        });
        const employee_div = document.getElementById('assign-employee-dropdown');
        if (employee_div) {
            employee_div.innerHTML = html;
        }
    }
});
//# sourceMappingURL=view_tickets.js.map