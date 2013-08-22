<?php
$page = Model_Page::Get($_REQUEST['pageid']);
if ($page->exists()) {
	$pm->setVariable('page', $page);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$page->delete();
		Typeframe::Redirect('Page deleted.', Typeframe::CurrentPage()->applicationUri());
	}
} else {
	Typeframe::Redirect('Invalid page specified.', Typeframe::CurrentPage()->applicationUri());
}
return;

/**
 * Typeframe Pages application
 *
 * admin delete controller
 */

// save typing below
$typef_app_dir = (TYPEF_WEB_DIR . '/admin/pages');

// can only process posts
if ('POST' != $_SERVER['REQUEST_METHOD'])
{
	//Typeframe::Redirect('Nothing to do.', $typef_app_dir);
	return;
}

// validate the page id
$pageid = @$_POST['pageid'];
$page   = Model_Page::Get($pageid);
if (!$page->exists())
{
	Typeframe::Redirect('Invalid page.', $typef_app_dir);
	return;
}

Model_Page::Delete($pageid);
Typeframe::Registry()->purgeRegistryCache();

Typeframe::Redirect('Page deleted.', $typef_app_dir);
