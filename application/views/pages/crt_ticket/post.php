<style>

    .body{
        margin: 0;
        padding: 0;
    }

    .container{
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(3, 1fr);
        border: 1px solid red;
        padding: 10px;
        gap: 10px;
    }
</style>

<div class="">
    <form id="create_ticket_form">
        <div class="container">
            <div class="gap-4">
                    <div class="subject">
                        <label for="">subject</label>
                        <input type="text" name="subject">
                    </div>

                    <div class="description">
                        <label for="">Description</label>
                        <input type="text" name="description">
                    </div>

                    <div class="">
                        <label for="attachment">Attachment</label>
                        <input type="file" name="attachments">
                    </div>
            </div>

            <div class="">
                <label for="department">Department</label>
                <select name="" id="department_dropdown" name="departments"></select>
            </div>
        </div>


        <div>
            <input type="submit">
        </div>
    </form>
</div>

<script src="../assets/JavaScript/jquery-4.0.0.min.js"></script>
<script src="../assets/JavaScript/create_ticket.js"></script>
