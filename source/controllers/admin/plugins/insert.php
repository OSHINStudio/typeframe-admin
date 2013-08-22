<?php
/**
 * Insert a plugin into a location (socket).
 */

// save typing below
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();

// requires POST
if ('POST' != $_SERVER['REQUEST_METHOD'])
	Bam_Json::FailureOrRedirect('Nothing to do.', $typef_app_dir);

// TODO: Handle the location rules
$rules = 'url:*';

// append plugin into location; get and check location id
$locid = Model_PlugLoc::Append($_POST['plugid'], $_POST['skin'], $_POST['socket'], $rules);
if (is_null($locid))
	Bam_Json::FailureOrRedirect('Error adding plugin to skin.', $typef_app_dir);

// build HTML if request is AJAX
if (requestIsAjax())
{
	$pm->setVariable('skin', $_POST['skin']);
	$pm->setVariable('p',   (new Plug_Loc($locid)));
	$html = $pm->writeText('<pm:include template="admin/plugins/socket-plugin.inc.html" />');
}
else
{
	$html = null;
}

// done; return result
Bam_Json::SuccessOrRedirect('Plugin added to skin.', "$typef_app_dir?skin={$_POST['skin']}", array('html' => $html));
