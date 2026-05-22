


const forApproval_tab = document.getElementById("forApproval_tab");

//for approval_tab
forApproval_tab.addEventListener('click', getForApprovalStatus);


function getForApprovalStatus(){

    const url = base_url + 'test/ajaxss';
    
    const xhr = new XMLHttpRequest;

    xhr.open('POST', url, true);

    xhr.onload = function(){

        

        try{
            const response = JSON.parse(this.responseText);
            if(xhr.status == 200){
                console.log(response);
            }

        }catch(error){
            console.log("Something is Wrong! NEGGA" + error)
        }


    }

    xhr.send();
}