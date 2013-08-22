<?php
/**
 * Typeframe Pages application
 *
 * admin add controller
 */
Typeframe::SetPageTemplate('/admin/pages/update.html');
$page = Model_Page::Create();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('update.inc.php');
	Typeframe::Redirect('Page created.', Typeframe::CurrentPage()->applicationUri());
}
require_once('options.inc.php');
