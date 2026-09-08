const table = document.getElementById("tablebody");

const forApproval_tab = document.getElementById("forApproval_tab");

const paginationBTN_1 = document.getElementById("paginationBtn_Page1");
const paginationBTN_2 = document.getElementById("paginationBtn_Page2");
const examplebutton = document.getElementById("refactoredtickts_BTTN");
const refactored_button = document.getElementById("refactored_button");
//for approval_tab
forApproval_tab.addEventListener("click", getForApprovalStatus);

examplebutton.addEventListener("click", paginationCount);
refactored_button.addEventListener("click", paginationCount);

function paginationCount() {
	const url = base_url + "get/all/forPagination";

	const xhr = new XMLHttpRequest();

	xhr.open("GET", url, true);

	xhr.onload = function () {
		try {
			const response = JSON.parse(this.responseText);
			//array na yung binigay satin ng ating pinka maamhal na waiter API

			if (xhr.status == 200) {
				const arraylenth = response.length;

				const numberofPagination = arraylenth / 5;
				// kung 40 yung binalik na data divide by 5 8 so means 8 cols

				let divs = "";

				for (let i = 0; i < numberofPagination; i++) {
					divs += `
					<span
                        data-offset='${i * 5}' data-limit='5'
                        class="paginationBTTN border border-black p-2">
                        <button>${i + 1}</button>
                    </span>
					
					 
					 `;
				}

				document.getElementById("container").innerHTML = divs;

				const paginationBTTN = document.querySelectorAll(".paginationBTTN");

				paginationBTTN.forEach((btn) => {
					btn.addEventListener("click", pageslogic);
				});
			}
		} catch (error) {
			console.log(error);
		}
	};

	xhr.onerror = function () {
		console.log("Network Error");
	};

	xhr.send();
}

function pageslogic() {
	let offset = this.getAttribute("data-offset");
	let limit = this.getAttribute("data-limit");

	const url = base_url + "test/page2/" + limit + "/" + offset;

	const xhr = new XMLHttpRequest();

	xhr.open("POST", url, true);

	xhr.onload = function () {
		try {
			const response = JSON.parse(this.responseText);
			if (xhr.status == 200) {
				let rows = "";

				response.result.forEach((ticket) => {
					let tcktAge = parseInt(ticket.Ticket_Age);
					let bg = "";
					let color = "";

					let createdate = new Date(ticket.created_at);
					let cleanDate  = createdate.toLocaleDateString('en-US', { 
						year: 'numeric', month: 'short', day: 'numeric',   hour: '2-digit' ,minute: '2-digit'
					});

					let updated_at = new Date(ticket.updated_at);
					let cleanUpdated  = createdate.toLocaleDateString('en-US', { 
						year: 'numeric', month: 'short', day: 'numeric',   hour: '2-digit' ,minute: '2-digit'
					});


					if (tcktAge > 8) {
						bg = "#FA5C5C";
						color = "white";
					} else if (tcktAge >= 4) {
						bg = "#FFE893";
						color = "gray";
					} else {
						bg = "#A3D78A";
						color = "gray";
					}

					rows += `
						<tr>
							<td class="px-3 py-3 text-cente r">
								<span class="p-2" style="background:${bg}; color:${color}"> 
									${ticket.Ticket_Age}
								</span>
							</td>
							<td class="px-3 py-3 text-center">
								<span class="code-badge">${ticket.ticket_code}</span>
							</td>
							<td class="px-3 py-3 text-sm text-slate-700 max-w-[180px] truncate" title="${ticket.title}">
								${ticket.title}
							</td>
							<td class="px-3 py-3 text-sm text-slate-600 text-center">${ticket.author_fullname}</td>
							<td class="px-3 py-3 text-center">
								<span class="badge ${(ticket.status)}">${ticket.status}</span>
							</td>
							<td class="px-3 py-3 text-center">
								<span class="badge ${(ticket.priority)}">${ticket.priority}</span>
							</td>
							<td class="px-3 py-3 text-sm text-slate-600 text-center">${ticket.dept_name}</td>
							<td class="px-3 py-3 text-xs text-slate-400 text-center">${cleanDate}</td>
							<td class="px-3 py-3 text-xs text-slate-400 text-center">${cleanUpdated}</td>
							<td class="px-3 py-3 text-center">
								<select class="text-xs p-1 rounded border border-slate-200 bg-white cursor-pointer">
									<option value="" selected disabled>Action</option>
									<option value="view">View</option>
								</select>
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

	xhr.onerror = function () {
		console.log("Network Error");
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
