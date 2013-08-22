<?php
require_once('common.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user = Model_User::Create();
	require_once('update.inc.php');
}
