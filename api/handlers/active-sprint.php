<?php
echo json_decode(file_get_contents("http://jira.local.mybit.nl/rest/agile/1.0/board/122/sprint?state=active"));