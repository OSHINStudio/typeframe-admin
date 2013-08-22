<?php
include('form.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usergroup = Model_Usergroup::Create();
	include('update.inc.php');
	Typeframe::Redirect('User group created.', Typeframe::CurrentPage()->applicationUri() . '/groups');
}
