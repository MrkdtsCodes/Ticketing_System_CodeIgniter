"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn = document.getElementById('AssignEmployeeBtn');
    const department_id = assign_btn ? assign_btn.getAttribute('data-department_id') : null;
    const form = document.getElementById('assignForm');
    let ticket_id = "";
    //get employee after the pages loads
    get_Employee();
    if (!assign_btn)
        return;
    const ticketid = assign_btn.getAttribute('data-ticket_id');
    const string_id = String(ticketid);
    ticket_id = string_id;
    console.log("ticket id is: ", ticket_id);
    form?.addEventListener('submit', function (e) {
        e.preventDefault();
        const employee_container = document.getElementById('assign-employee-dropdown');
        if (!employee_container)
            return;
        const checked = employee_container.querySelectorAll('input[type="checkbox"]:checked');
        const employees = Array.from(checked).map(cb => ({
            account_id: cb.value,
            employee_id: cb.dataset.employee_id ?? "",
            employee_name: cb.dataset.employee_name ?? "",
            ticket_id: ticket_id ?? ""
        }));
        assign_emp(employees);
    });
    async function assign_emp(employees = []) {
        if (employees.length === 0) {
            alert("You must choose 1 or More Employees");
            return;
        }
        try {
            const response = await fetch(base_url + 'assign/employee', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ employees })
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message ?? `Request failed: ${response.status}`);
            }
            alert(`${result.assigned} employee(s) assigned.`);
        }
        catch (err) {
            console.error(err);
            alert('Could not assign employees. Please try again.');
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
                        data-employee_name="${element.employee_fullname}"
                        >
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