<?php

$context = stream_context_create(array(
  'http' => array(
    'header'  => "Authorization: Basic " . "dGltOjFTbG9nZ2kx"
  )
));
$active_sprints = json_decode(file_get_contents("https://jira.local.mybit.nl/rest/agile/1.0/board/95/sprint?state=active", false, $context));
$sprint = false;
foreach ($active_sprints->values as $active_sprint) {
  if(strpos(strtolower($active_sprint->name), 'notuback') !== false) {
    $sprint_issues = json_decode(file_get_contents($active_sprint->self."/issue", false, $context));
    break;
  }
}
$column_config = json_decode(file_get_contents("https://jira.local.mybit.nl/rest/agile/1.0/board/95/configuration", false, $context));

$assignees = array();
$project_keys = array();
foreach($sprint_issues->issues as $issue) {
  if(isset($issue->fields->assignee)){
    if(!in_array($issue->fields->assignee->displayName, $assignees)){
      array_push($assignees, $issue->fields->assignee->displayName);
    }
  }
  if(isset($issue->key)){
    $key = explode("-", $issue->key);
    if(!in_array($key[0], $project_keys)){
      array_push($project_keys, $key[0]);
    }
  }
}
function humanTiming ($time) {
  $time = time() - $time; // to get the time since that moment
  $time = ($time<1)? 1 : $time;
  $tokens = array (
    31536000 => 'year',
    2592000 => 'month',
    604800 => 'week',
    86400 => 'day',
    3600 => 'hour',
    60 => 'minute',
    1 => 'second'
  );
  foreach ($tokens as $unit => $text) {
    if ($time < $unit) continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
  }
}

$cur_datetime = time();
$ticket_verlopen = false;

asort($assignees); ?>
<div id="open_close_filters"><span class="aui-icon aui-icon-small aui-iconfont-appswitcher"></span></div>
<div id="filters">
  <dl class="ghx-controls-filters js-quickfilter-selector">
    <div id="js-work-quickfilters" class="aui-expander-content ghx-quick-content">
      <dt id="js-quickfilters-label" class="ghx-cursor-help" data-tooltip="Use Quick Filters to view a subset of issues. Add more in the board configuration." original-title="">Assignee Filter:</dt>
      <?php foreach($assignees as $assignee){ ?>
        <dd>
          <a role="button" href="#" class="js-quickfilter-button assignee-filter" title="Displays issues which are currently assigned to the current user"><?= $assignee ?></a>
        </dd>
      <?php } ?>
    </div>
  </dl>
  <dl class="ghx-controls-filters js-quickfilter-selector">
    <div id="js-work-quickfilters" class="aui-expander-content ghx-quick-content">
      <dt id="js-quickfilters-label" class="ghx-cursor-help" data-tooltip="Use Quick Filters to view a subset of issues. Add more in the board configuration." original-title="">Project Filter:</dt>
      <?php foreach($project_keys as $project_key){ ?>
        <dd>
          <a role="button" href="#" class="js-quickfilter-button project-filter" title="Displays issues which are currently assigned to the current user"><?= $project_key ?></a>
        </dd>
      <?php } ?>
    </div>
  </dl>
</div>

<ul id="ghx-column-headers" class="ghx-column-headers"> <?php
  if(isset($column_config->columnConfig->columns))
    foreach ($column_config->columnConfig->columns as &$configuration) { ?>
      <?php
      $configuration->statuslist = [];
      foreach ($configuration->statuses as $status) {
        $configuration->statuslist[] =  $status->id;
      }
      ?>
      <li class="ghx-column" data-column-id="<?=$configuration->name?>">
        <h2> <?=$configuration->name?> </h2>
      </li> <?php
    } ?>
</ul>

<?php ?>

<ul class="ghx-columns">
  <?php
  foreach($column_config->columnConfig->columns as $column){
    echo "<li class='ghx-column' data-column-id='".$column->name."'>";
    foreach($sprint_issues->issues as $issue) {
      if(in_array($issue->fields->status->id, $column->statuslist)){
        $summary_title = strlen($issue->fields->summary) > 70 ? substr(explode("\n", wordwrap($issue->fields->summary))[0],0,70)."..." : $issue->fields->summary;
        //duedate aanwezig

        echo "<div class='js-detailview ghx-issue js-issue js-parent-drag ghx-days-51 ghx-type-1' data-issue-key='".$issue->key."'>";
        echo "<div class='ghx-issue-content'>
                                            <div class='ghx-issue-fields'>
                                               <span class='ghx-type' title='".$issue->fields->issuetype->name."'>";
        if(isset($issue->fields->issuetype->iconUrl) && strpos($issue->fields->issuetype->iconUrl, 'download') == false){
          echo "<img src='".$issue->fields->issuetype->iconUrl."'>";
        }
        echo "</span>
                                                <div class='ghx-key'>
                                                    <a href='https://jira.local.mybit.nl/browse/".$issue->key."' title='".$issue->key."' target='_blank' class='js-key-link'>".$issue->key."</a>
                                                </div>
                                                <div class='ghx-summary' title='".$issue->fields->summary."'>
                                                    <span class='ghx-inner'>".$summary_title."</span>
                                                </div>
                                            </div>
                                            ";

        if(isset($issue->fields->customfield_10303)){
          echo "<div class='ghx-end'>
                                                    <div class='ghx-corner'>
                                                        <span class='aui-badge' title='Story Points'>".$issue->fields->customfield_10303."</span>
                                                    </div>
                                                </div>";
        }
        echo "</div>";

        if (isset($issue->fields->assignee->avatarUrls->{"32x32"})) {

          echo "<div class='ghx-avatar'>";
          echo "<span class='ghx-avatar-img' style='background-image: url(\"".$issue->fields->assignee->avatarUrls->{"32x32"}."\")' data-assignee='".$issue->fields->assignee->displayName."' data-tooltip='". $issue->fields->assignee->displayName ."'></span>";
          echo "</div>";
        } elseif (isset($issue->fields->assignee->displayName)){
          echo "<div class='ghx-avatar'>";
          echo "<span class='ghx-avatar-img' style='background-color: #EF4035' data-assignee='".$issue->fields->assignee->displayName."' data-tooltip='". $issue->fields->assignee->displayName ."'>".substr($issue->fields->assignee->displayName, 0, 1)."</span>";
          echo "</div>";
        }

        echo "</div>";
      }

    }
    echo "</li>";
  } ?>
</ul>
</div><?php
?>

<script type="text/javascript">
  //toggle list
  $('.aui-iconfont-expanded').on('click', function(){
    $(this).closest('.ghx-swimlane-header').next('.ghx-columns').toggle();
    $(this).closest('.ghx-swimlane').toggleClass('ghx-closed');
  });

  $(function() {
    $.each($(".overdue"), function() {
      var tocolor = "#BF3022";
      var fromcolor = "#FFFFFF";
      var $element =  $(this),cycle;
      (cycle = function() {
        $element.animate({backgroundColor:fromcolor}, 1750).animate({backgroundColor:tocolor}, 1750,cycle);
      })();
    });
  });
</script>