<?php
require_once('common.inc.php');
$user = Model_User::Get($_REQUEST['userid']);
if (!$user->exists()) {
	Typeframe::Redirect('Invalid user specified.', Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}
$pm->setVariable('user', $user);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('update.inc.php');
}
