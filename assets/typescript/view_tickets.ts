document.addEventListener("DOMContentLoaded", () => {

    const base_url: string = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn: HTMLElement | null = document.getElementById('AssignEmployeeBtn');
    const department_id: string | null = assign_btn ? assign_btn.getAttribute('data-department_id') : null;

    
    

    get_Employee();

    async function get_Employee(){
        let response = await fetch(base_url + 'tickets/Reassign/getemployees/' + department_id)
        
        //lahat ng ibabalik mo need natin ng data type niya
        type Employee = {
            account_id: string;
            employee_fullname: string;
            dept_name: string;
            id: string;
            employee_id: string;
        }
        let text: Employee[] = await response.json();
        console.table(text);

        let html: string = '';

        text.forEach(element => {
            html += `
                <label class="flex items-center gap-2 p-1">
                <input type="checkbox" name"employee_name[]">${element.employee_fullname}
                </label>
            `
        });

        const employee_div: HTMLElement | null  = document.getElementById('assign-employee-dropdown');
        if (employee_div) {
            employee_div.innerHTML = html;
        }
        
        


        
    }
});