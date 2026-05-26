const table = document.getElementById("tablebody");

const forApproval_tab = document.getElementById("forApproval_tab");

const paginationBTN_1 = document.getElementById("paginationBtn_Page1");
const paginationBTN_2 = document.getElementById("paginationBtn_Page2");
const examplebutton = document.getElementById("sampletable");

//for approval_tab
forApproval_tab.addEventListener("click", getForApprovalStatus);



examplebutton.addEventListener("click", pageslogic);
paginationBTN_1.addEventListener('click', pageslogic);
paginationBTN_2.addEventListener('click', pageslogic);

function pageslogic(){
		let offset = this.getAttribute('data-offset');
		let limit = this.getAttribute('data-limit');


	const url = base_url + "test/page2/" + limit + "/" + offset ;

	const xhr = new XMLHttpRequest();

	xhr.open("POST", url, true);

	xhr.onload = function () {
		try {
			const response = JSON.parse(this.responseText);
			if (xhr.status == 200) {
				let rows = "";

				response.result.forEach((ticket) => {
					rows += `
						                   
                        <tr class="bg-white hover:bg-slate-50 transition border border-slate-100 rounded-lg">

                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <div> 
                                    ${ticket.id}
                                </div>

                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
								${ticket.ticket_code}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
								${ticket.title}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
								${ticket.author_fullname}
                            </td>
<!--                             
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                <?php echo $pics ?>
                            </td>s -->
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                               ${ticket.status}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                ${ticket.priority}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                ${ticket.dept_name}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                 ${ticket.created_at}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 text-center">
                                ${ticket.updated_at}
                            </td>
                            <td class="">
                                <div>
                                    <div class="flex">
                                        <select name="" id=""
                                        class="text-sm p-1">
                                            <option value="" selected disabled>Action</option>
											<option value="">view</option>
                                        </select>
                                    </div>
                                </div>
                            </td>

                        </tr>


					`;
				});

				document.getElementById("tablebody").innerHTML = rows;
			}
		} catch (error) {
			console.log("Something is Wrong! NEGGA" + error);
		}
	};

	xhr.send();
}


function getForApprovalStatus() {
	const url = base_url + "test/ajax";

	const xhr = new XMLHttpRequest();

	xhr.open("POST", url, true);

	xhr.onload = function () {
		try {
			const response = JSON.parse(this.responseText);
			if (xhr.status == 200) {
				console.log(response);
			}
		} catch (error) {
			console.log("Something is Wrong! NEGGA" + error);
		}
	};

	xhr.send();
}
