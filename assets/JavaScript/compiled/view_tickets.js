"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn = document.getElementById('AssignEmployeeBtn');
    const department_id = assign_btn ? assign_btn.getAttribute('data-department_id') : null;
    get_Employee();
    async function get_Employee() {
        let response = await fetch(base_url + 'tickets/Reassign/getemployees/' + department_id);
        let text = await response.json();
        console.table(text);
        let html = '';
        text.forEach(element => {
            html += `
                <label class="flex items-center gap-2 p-1">
                <input type="checkbox" name"employee_name[]">${element.employee_fullname}
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