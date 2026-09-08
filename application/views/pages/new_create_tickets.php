<div class="">
    <main>
        <form >
            <table data-orderder_by="">
                <thead>
                    <tr>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                     <input type="text" data-order_by="desc">


                     <input type="submit">

                     
                </tbody>
            </table>
        </form>
    </main>
    <button id="button" data-method="refactored">click me!</button>
</div>

<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function (){
        const base_url = 'http://localhost/Projects/TICKETING_SYSTEM/';

        var path = $('#button').attr('data-method');
        console.log(path);

        $("button").click(function(){
            console.log("you clicked me!");
        });
        let array_values = {
            firstname: "mark",
            lastname: "Datus"
        };

        let car = {
            brand: "Ford",
            model: "Mustang",
            year: 1964
        };

        $.ajax({
            contentType: 'application/json',
            data:JSON.stringify({data:array_values}),
            success(response){
                console.log("response is: ", response);
            },
            error(error){
                console.error(error);
            },
            processData: false,
            type: 'POST',
            url: 'http://localhost/Projects/TICKETING_SYSTEM/Pages/display_new_createTicket'
        });
    });
</script>