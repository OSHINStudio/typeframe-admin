<?php
/**
 * Typeframe Pages application
 *
 * admin index controller
 *
 * TODO: Figure a way to connect pages to their appropriate admin
 * applications (Content to Content Admin, News to News Admin, etc.).
 */

// save typing below
$typef_app_dir = (TYPEF_WEB_DIR . '/admin/pages');

// validate the incoming page id (for pagination)
$page = @$_REQUEST['page'];
if (!$page || ($page < 1)) $page = 1;
$pm->setVariable('page', $page);

// get all pages; sort by nickname and uri; paginate
$pages = new Model_Page();
$pages->where('siteid = ?', Typeframe::CurrentPage()->siteid());
$pages->order('nickname, uri');
$pages->setPagination($page, 100);

// add pages to template; set up pagination
foreach ($pages->getAll() as $page)
{
	if (Typeframe::Registry()->application($page['application'])) {
		//$page['admin'] = Typeframe::Registry()->application($page['application'])->admin();
	} else {
		trigger_error("Application '{$page['application']}' is not registered");
	}
	$pm->addLoop('pages', $page);
}
//$pm->setVariable('totalpages', $pages->getTotalPages());
//$pm->setVariable('pagedurl',   $typef_app_dir);
$pm->setVariableArray(Pagination::Calculate($pages->count(), 100, $pm->getVariable('page'), $typef_app_dir));
// add applications to template
$applications = array();
foreach (Typeframe::Registry()->applications() as $app)
{
	if (!preg_match('/ Admin$/', $app->name())) continue;

	$applications[$app->title()] = array
	(
		'name' => $app->name(),
		/*'map'  => $app->map(),*/
		'base' => $app->base()
	);
}
$pm->setVariable('applications', $applications);
