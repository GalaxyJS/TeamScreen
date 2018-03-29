<?php include('../header.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../../assets/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" type="text/css" href="../../assets/jquery.datetimepicker.min.css"/ >

<div id="general">
    <h2>Voeg vrije tijd toe voor:</h2>
    <h3><?= $member->getName() ?></h3>

    <form action="add.php" method="post">
        <input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>" />
        <div>
            <label for="start">Startmoment:</label>
            <input class="datetimepicker" type="text" id="start" name="start" readonly/>
        </div>

        <div>
            <label for="end">Eindmoment:</label>
            <input class="datetimepicker" type="text" id="end" name="end" readonly/>
        </div>

        <button name="addTimeOffButton" type="submit">Voeg toe</button>
    </form>
</div>

<script>
    jQuery('.datetimepicker').datetimepicker({
        format: 'Y-m-d H:i',
        allowTimes:[
            '7:00',
            '7:30',
            '8:00',
            '8:30',
            '9:00',
            '9:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00',
            '16:30',
            '17:00',
            '17:30',
            '18:00',
            '18:30'
        ]
    });
</script>