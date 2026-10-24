document.addEventListener("DOMContentLoaded", () => {
    
    const base_url: string = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn: HTMLElement | null = document.getElementById('AssignEmployeeBtn');
    const department_id: string | null = assign_btn ? assign_btn.getAttribute('data-department_id') : null;
    const form = document.getElementById('assignForm') as HTMLFormElement | null;

    //get employee after the pages loads
    get_Employee();

    form?.addEventListener('submit', function(e){
        e.preventDefault();
        const employee_container: HTMLElement | null = document.getElementById('assign-employee-dropdown');

        if (!employee_container) return;  
        const checked = employee_container.querySelectorAll<HTMLInputElement>('input[type="checkbox"]:checked');

        const emp_ids: string[] = Array.from(checked).map(cb => cb.value);

        assign_employee(emp_ids);
    });


    function assign_employee(emp_ids: string[] = []){

        if(emp_ids.length == 0){
            alert("You must choose 1 or More Employees");
        }

        

    }


    
    

    




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
                <label class="flex items-center gap-2 p-1 cursor-pointer">
                    <input type="checkbox" name="employee_ids[]" value="${element.account_id}"
                        data-employee_id="${element.account_id}"
                        data-employee_name="${element.employee_fullname}">
                    ${element.employee_fullname}
                </label>
            `
        });

        const employee_div: HTMLElement | null  = document.getElementById('assign-employee-dropdown');
        if (employee_div) {
            employee_div.innerHTML = html;
        }
        
        


        
    }
});