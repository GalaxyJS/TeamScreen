<!-- authors : Dominic Dingena & Agung Udijana -->

<div id="general">
    <h1><img src = "/teamscreen/views/member/configtransparent.png"> Ledenconfiguratie</h1>

    <div id = "messageblock">
    <span><div id="message"><h2><?= $_SESSION['message'] ?? '' ?></h2></div></span>
    <?php unset ($_SESSION['message']); ?>
    </div>

    <div id="member-list">
        <ul id="members">
            <div class="scrollable">
            <?php foreach ($members as $member) { ?>

                <li class='memberlist'>
                    <img class="userimg"
                         src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=small&ownerId=<?= $member->getUsername(); ?>"/>
                    <span><?= $member->getName() ?></span>
                    <!-- <span><a href="edit.php?id=<?= $member->getId() ?>"><?= $member->getName() ?></a></span> -->


                    <span class="edit"><a href="edit.php?id=<?= $member->getId() ?>"><span class='icon'><img
                                        src="../../views/member/edit.png"/></a></span>

                    <span class="freetime"><a href="../timeoff/add.php?id=<?= $member->getId() ?>"><span class='icon'><img
                                        src="../../views/member/calendar.png"/></a></span>
                </li>

            <?php } ?>
            </div>
    </ul>



        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script>
            //When the page has loaded.
            $( document ).ready(function(){
                $('#message').fadeIn('slow', function(){
                    $('#message').delay(4000).fadeOut();
                });
            });
        </script>


    </div>
</div>