const addUsr_btnn = document.getElementById("addUsr_btnn");
const CreateEmployeeModal = document.getElementById("createAccountModal");

const closeCreateModal = document.getElementById("closeCreateModal");



addUsr_btnn.addEventListener('click', function(){

    CreateEmployeeModal.style.display = "flex";

});

closeCreateModal.addEventListener('click', function(){

    CreateEmployeeModal.style.display = "none";

});