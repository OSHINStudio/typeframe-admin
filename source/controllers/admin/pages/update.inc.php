<?php
$page->setArray($_POST);
$page->save();
$pageperms = new Model_PagePerm();
$pageperms->where('pageid = ?', $page['pageid']);
$pageperms->deleteQuery();
if ((isset($_REQUEST['usergroupid'])) && (count($_REQUEST['usergroupid']) > 0) && (array_search('0', $_REQUEST['usergroupid']) === false))
{
	foreach ($_REQUEST['usergroupid'] as $usergroupid)
	{
		//$pageperm = new PagePerm($page->get('id'), $usergroupid);
		//$pageperm->save();
		$pageperm = Model_PagePerm::Create();
		$pageperm['pageid'] = $page['id'];
		$pageperm['usergroupid'] = $usergroupid;
		$pageperm->save();
	}
}
else
{
	//$pageperm = new PagePerm($page->get('id'), 0);
	$pageperm = Model_PagePerm::Create();
	$pageperm['pageid'] = $page['id'];
	$pageperm['usergroup'] = 0;
	$pageperm->save();
}
Typeframe::Registry()->purgeRegistryCache();
