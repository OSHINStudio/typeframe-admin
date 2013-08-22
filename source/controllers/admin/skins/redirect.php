<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if ($_REQUEST['config'] == 'Skins') {
	$phrameworks->redirect('Redirecting to Skins admin...', PHRAME_WEB_DIR . '/admin/skins');
	$phrameworks->stop();
}
?>