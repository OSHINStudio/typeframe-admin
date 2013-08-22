<?php
$usergroups = new Model_Usergroup();
$usergroups->order('usergroupname');
$selected = array();
if ($page->exists()) {
	$selectedGroups = new Model_PagePerm();
	$selectedGroups->where('pageid = ?', $page['id']);
	foreach ($selectedGroups->getAll() as $s) {
		$selected[] = $s['usergroupid'];
	}
}
$pm->addLoop('usergroups', array
(
	'usergroupid'   => '0',
	'usergroupname' => 'Everyone',
	'selected'      => (in_array(0, $selected) ? true : false)
));
foreach ($usergroups->getAll() as $usergroup) {
	if (in_array($usergroup['usergroupid'], $selected)) {
		$usergroup['selected'] = true;
	}
	$pm->addLoop('usergroups', $usergroup);
}

foreach (Typeframe::Registry()->applications() as $app)
{
	//if ('soft' == $app->map())
		$pm->addLoop('applications', array('application' => $app->name()));
}
$pm->sortLoop('applications', 'application');
if (PAGES_DEFAULT_APPLICATION)
{
	$app = Typeframe::Registry()->application(PAGES_DEFAULT_APPLICATION);
	//if ($app && ('soft' == $app->map()))
	if ($app)
		$pm->setVariable('application', PAGES_DEFAULT_APPLICATION);
}

// add skins to template
foreach (Typeframe::GetSkins() as $skin)
	$pm->addLoop('skins', array('skin' => $skin));
$pm->setVariable('typef_site_skin', TYPEF_SITE_SKIN);

$application = Typeframe::Registry()->application($page['application']);
if ($application && $application->admin()) {
	if (file_exists(TYPEF_SOURCE_DIR . '/scripts' . $application->admin() . '/settings.php')) {
		Typeframe::IncludeScript($application->admin() . '/settings.php');
	}
}
