<?php
/**
 * Typeframe Pages application
 *
 * admin settings controller
 */

$pageid = @$_REQUEST['pageid'];
$page   = Model_Page::Get($pageid);
if ($page->exists())
{
	$settings = $page->get('settings');
	if ($settings)
	{
		$pm->addLoop('settings', $settings);
	}
}
$name = $_REQUEST['application'];
$application = Typeframe::Registry()->application($name);
if ($application && $application->admin()) {
	if (file_exists(TYPEF_SOURCE_DIR . '/scripts' . $application->admin() . '/settings.php')) {
		Typeframe::IncludeScript($application->admin() . '/settings.php');
	}
}
