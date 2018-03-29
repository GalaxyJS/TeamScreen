<?php


$tabMembers = $allMembers;




?>

<div id="daysOff" class="widgetBoxSmall">
    <h2>&#127958 Vrije dagen</h2>

    <div id="timeOff-list">
        <?php foreach ($tabMembers as $member): ?>
        <div class="timeOff-item">
            <span><img src="https://jira.local.mybit.nl/secure/useravatar?size=small&ownerId=<?= $member->getUsername(); ?>"/></span>
            <ul>
                <li><span><?= $member->getName(); ?></span></li>
                <li><span>&#128197 05-03-2018 &#128336 vanaf 12:30</span></li>
            </ul>
        </div>
        <?php endforeach; ?>

    </div>




</div>