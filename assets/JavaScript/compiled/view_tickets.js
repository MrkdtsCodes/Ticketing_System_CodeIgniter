"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn = document.getElementById('AssignEmployeeBtn');
    const department_id = assign_btn ? assign_btn.getAttribute('data-department_id') : null;
    async function get_Employee() {
        let response = await fetch(base_url + 'tickets/Reassign/getemployees/' + department_id);
        let text = await response.text();
        console.log(text);
    }
    get_Employee();
});
//# sourceMappingURL=view_tickets.js.map