<link rel="stylesheet" href="widgets/timeOff.css">

<?php
/**
 * TIME OFF WIDGET
 *
 * @author Vincent Huijts
 * @review Carina Boom
 */

$timeOffItems = &$timeOffNextTwoWeeks;

$islandIcon = '&#127958';
$calendarIcon = '&#128197';
$clockIcon = '&#128336';
$workDayEnd = 17;
$workDayStart = 9;
$fullWorkDay = 8;

/**
 * returns different formatted strings based on start and enddate of leave
 * multiple days = startdate t/m enddate
 * single day = startdate
 * single day back before end = enddate + time
 *
 * @param $startDate
 * @param $endDate
 * @return string
 */
function dateString($startDate, $endDate) : string
{

    global $fullWorkDay, $clockIcon;

    $sameDay = date_format($startDate, 'd-m') === date_format($endDate, 'd-m');
    $partDay = ((int)date_format($endDate, 'H')) - ((int)date_format($startDate, 'H')) < $fullWorkDay;

    if ($sameDay && $partDay) {
        $result = date_format($startDate, 'd-m') . ' ' . $clockIcon . ' ' . date_format($startDate, 'H:i')
            . ' t/m ' . date_format($endDate, 'H:i');
    } elseif ($sameDay) {
        $result = date_format($endDate, 'd-m');
    } else {
        $result = date_format($startDate, 'd-m') . ' t/m ' . date_format($endDate, 'd-m');

    }
    if(!$result) return "";
    return $result;
}

?>

<div id="timeOff" class="widgetBoxSmall">
    <h2><?= $islandIcon; ?> Vrije dagen</h2>

    <div id="timeOff-list">
        <?php foreach ($timeOffItems as $unit) : ?>
            <div class="timeOff-item">
                <span class="timeOff-box" "timeOff-avatar">
                <img class="userimg"
                     src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=small&ownerId=<?= $unit->getMember()->getUsername(); ?>"/>
                </span>
                <span class="timeOff-box" "memberInfo">
                <span class="timeOff-name"><?= $unit->getMember()->getName(); ?></span>
                <span class="timeOff-date">
                <?= $calendarIcon; ?>
                <?= dateString(new DateTime($unit->getStartTime()), new DateTime($unit->getEndTime())); ?> </span>
                </span>
            </div>
        <?php endforeach; ?>
    </div>


</div>