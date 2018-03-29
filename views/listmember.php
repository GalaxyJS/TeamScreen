<div id="general">
    <h1>Kies een lid:</h1>

    <ul>
        <?php foreach($members as $member){ ?>
            <li>
                <span><a href="edit.php?id=<?= $member->getId() ?>"><?= $member->getName() ?></a></span>
                <span><a href="edit.php?id=<?= $member->getId() ?>">wijzig</a></span>
                <span><a>verlof</a></span>
            </li>
        <?php } ?>
    </ul>
</div>
