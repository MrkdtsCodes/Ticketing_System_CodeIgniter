const table = document.getElementById("tablebody");

const forApproval_tab = document.getElementById("forApproval_tab");

const paginationBTN_2 = document.getElementById("paginationBtn_Page2");
//for approval_tab
forApproval_tab.addEventListener("click", getForApprovalStatus);

paginationBTN_2.addEventListener("click", () => {
	const offset = 5;

	const url = base_url + "test/page2";

	const xhr = new XMLHttpRequest();

	xhr.open("POST", url, true);

	xhr.onload = function () {
		try {
			const response = JSON.parse(this.responseText);
			if (xhr.status == 200) {
				let rows = "";

				response.result.forEach((ticket) => {
					rows += `
            <tr>
                <td>${ticket.id}</td>
                <td>${ticket.ticket_code}</td>
                <td>${ticket.title}</td>
                <td>${ticket.author_fullname}</td>
                <td>${ticket.status}</td>
                <td>${ticket.priority}</td>
                <td>${ticket.dept_name}</td>
                <td>${ticket.created_at}</td>
                <td>${ticket.updated_at}</td>
            </tr>
        `;
				});

				document.getElementById("tablebody").innerHTML = rows; // ✅ outside loop
			}
		} catch (error) {
			console.log("Something is Wrong! NEGGA" + error);
		}
	};

	xhr.send();
});

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
