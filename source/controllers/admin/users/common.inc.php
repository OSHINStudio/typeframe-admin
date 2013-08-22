<?php
Typeframe::SetPageTemplate('/admin/users/update.html');
$usergroups = new Model_Usergroup();
$pm->setVariable('usergroups', $usergroups);
