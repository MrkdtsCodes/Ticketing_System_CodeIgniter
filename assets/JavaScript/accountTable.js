const addUsr_btnn = document.getElementById("addUsr_btnn");
const editUsr_btnn = document.querySelectorAll('.deactivatebtn');

const CreateEmployeeModal = document.getElementById("createAccountModal");
const editEmployeeModal = document.getElementById("editAccountModal");


const closeCreateModal = document.getElementById("closeCreateModal");
const closeeditModal = document.querySelectorAll('.closeeditModal');

const close_update_button = document.getElementById('close_update_button');
const dataTable = document.getElementById('dataTable');

const archive_btnn = document.querySelectorAll('.archive_btnn');

addUsr_btnn.addEventListener('click', function(){

    CreateEmployeeModal.style.display = "flex";

});

editUsr_btnn.forEach(function(button){
    button.addEventListener('click', function(){
       
        const display = editEmployeeModal.style.display;

        //inputs sa modal yung lalagyan ng dta

        //yung dala-dala ng button natin butotn data yung laman nito hindi yang sa taas 
        const account_id = this.getAttribute('data-id');
        const firstname = this.getAttribute('data-fname');
        const lastname = this.getAttribute('data-lname');
        const middlename = this.getAttribute('data-mname');
        const bdate = this.getAttribute('data-bdate');
        const address = this.getAttribute('data-address');
        const zip = this.getAttribute('data-zip');
        const email = this.getAttribute('data-email');
        const deptname = this.getAttribute('data-departmentID');
        const rolename = this.getAttribute('data-roleID');


        document.getElementById('edit_firstname').value = firstname
        document.getElementById('edit_lastname').value = lastname
        document.getElementById('edit_middlename').value = middlename
        document.getElementById('edit_bdate').value = bdate
        document.getElementById('edit_address').textContent = address
        document.getElementById('edit_zipcoode').value = zip
        document.getElementById('edit_email').value = email
        document.getElementById('edit_department').value = deptname
        document.getElementById('edit_role').value = rolename
        document.getElementById('edit_accountID').value = account_id
        

        


        if(display === "none"){

            editEmployeeModal.style.display = "flex";
        };
        
    });
});

closeCreateModal.addEventListener('click', function(){

    CreateEmployeeModal.style.display = "none";



});

closeeditModal.forEach(function(button){
    button.addEventListener('click', function(){
       
        const display = editEmployeeModal.style.display;

        if(display === "flex"){

        editEmployeeModal.style.display = "none";

        reloaddatatable();

        };
        
    });
});

const updateAccountBtnn = document.getElementById('updateAccountBtnn');

updateAccountBtnn.addEventListener('click', updateloadTxt);

function updateloadTxt(event){

    event.preventDefault;
    // 1. get the id from hidden input

    const account_id = document.getElementById('edit_accountID').value;

    // 2. build the url here
    const url = BASE_URL + 'tickets/update/account/' + account_id;

    // 3. grab form data here
    const form = document.getElementById('editAccountForm');
    const formData = new FormData(form);

    // 4. create XHR
    const xhr = new XMLHttpRequest();

    // 5. open
    xhr.open('POST', url, true);

    // 6. onload handles the response
    xhr.onload = function(){
        if(this.status == 200){
            console.log(this.responseText);
            alert("Update user Successfully!");

        }else{
            console.log("this wont send");
        }
    }

    // 7. send WITH formData
    xhr.send(formData);
}






function reloaddatatable(){

    const userTableBody = document.getElementById('userTableBody');

    const url = BASE_URL + 'tickets/updatedaccount';


    const xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.onload = function(){

        if(this.status == 200){

            const response = JSON.parse(this.responseText);

            const tbody = document.getElementById('userTableBody');

            tbody.innerHTML = "";

            response.accounts.forEach(function(acc){

                
            });

        }else{
                console.log("this wont send");
            }
        
    }
    xhr.send();






}

archive_btnn.forEach(function(btnn){

    btnn.addEventListener('click', function(){

    const id = this.getAttribute('data-id');

    console.log(id);

    const url = BASE_URL + 'tickets/update/status/' + id;
    
    const xhr = new XMLHttpRequest();

    xhr.open(
        'GET',
        url,
        true
    );

    xhr.onload = function(){
        
        //taga kuha at tagabigay ng data


    const response = JSON.parse(this.responseText);

    if(response.message === "success"){

        alert("Employee successfully deactivated");
        location.reload();

    }else if(response.message === "failed"){

        alert("Failed to deactivate employee");
        location.reload();

    }else if(response.message === "inactive"){

        alert("Employee already inactive");
        location.reload();

    }else{

        alert("Employee does not exist");
        location.reload();

    }
    }
    xhr.send();




    });

});
    


