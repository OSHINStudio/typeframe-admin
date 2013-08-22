<?php
/**
 * Typeframe Pages application
 *
 * admin edit controller
 */
Plugin_Breadcrumbs::Add('Edit');
Typeframe::SetPageTemplate('/admin/pages/update.html');
$page = Model_Page::Get($_REQUEST['pageid']);
if ($page->exists()) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		require_once('update.inc.php');
		Typeframe::Redirect('Page updated.', Typeframe::CurrentPage()->applicationUri());
	}
	$pm->setVariable('page',   $page->getAsArray());
	$pm->setVariable('pageid', $page->get('pageid'));
	$settings = $page->get('settings');
	$pm->setVariable('settings', $settings);
	require_once('options.inc.php');
} else {
	Typeframe::Redirect('Invalid page specified.', Typeframe::CurrentPage()->applicationUri());
}
