// $(document).ready(function () {

//     $('#editAccountForm').submit(function (e) {

//         e.preventDefault();

//         const accountid = $('#edit_accountID').val();

//         $.ajax({

//             url: BASE_URL + 'tickets/update/account/' + accountid,
//             type: "POST",
//             data: $(this).serialize(),
//             dataType: "json",

//             success: function (data) {

//                 console.log(data);

//             },

//             error: function () {

//                 console.log('Ajax failed to send the request');

//             }

//         });

//     });

// });