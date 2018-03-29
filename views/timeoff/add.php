<?php include('../header.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../../assets/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" type="text/css" href="../../assets/jquery.datetimepicker.min.css"/ >

<div id="general">
    <h1><img src = "../../views/timeoff/beach.png"> Vrije tijd</h1>

    <h2><img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=large&ownerId=<?= $member->getUsername(); ?>"/> <?= $member->getName() ?></h2>

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

        <button name="addTimeOffButton" type="submit" class="button2">Voeg toe</button>
    </form>
</div>

<script>
    jQuery('.datetimepicker').datetimepicker({
        format: 'Y-m-d H:m:s'
    });
</script>