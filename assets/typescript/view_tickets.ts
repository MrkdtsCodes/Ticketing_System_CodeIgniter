document.addEventListener("DOMContentLoaded", () => {

    const base_url: string = 'http://localhost/Projects/TICKETING_SYSTEM/';
    const assign_btn: HTMLElement | null = document.getElementById('AssignEmployeeBtn');
    const department_id: string | null = assign_btn ? assign_btn.getAttribute('data-department_id') : null;

    
    async function get_Employee(){
        let response = await fetch(base_url + 'tickets/Reassign/getemployees/' + department_id)
        let text:string = await response.text();

        console.log(text)
    }

    get_Employee();


});