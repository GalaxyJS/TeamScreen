<!-- authors : Dominic Dingena & Agung Udijana -->

<div id="general">
    <h1>Ledenconfiguratie</h1>

    <h2><?= $_SESSION['message'] ?? '' ?></h2>
    <?php unset ($_SESSION['message']); ?>

    <table id="members">
        <?php foreach($members as $member){ ?>
            <tr>
                <td style="width:150px"><a href="edit.php?id=<?= $member->getId() ?>"><?= $member->getName() ?></a></td>
                <td><a href="../timeoff/add.php?id=<?= $member->getId() ?>" class="vrijetijd">Voeg vrije tijd toe</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
