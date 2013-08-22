<?php
/**
 * Edit a plugin.
 */

Plugin_Breadcrumbs::Add('Edit');

// save typing below
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();

// get and validate plugin id
$plugid = trim(@$_REQUEST['plugid']);
$plug   = Model_Plug::Get($plugid);
if (!$plug->exists())
{
	Typeframe::Redirect('Invalid plugin id.', $typef_app_dir);
	return;
}

// get skin, if any; add to template
$skin = trim(@$_REQUEST['skin']);
if (strlen($skin) > 0)
	$pm->setVariable('skin', $skin);

// decode settings as configuration; initialize plugin
$configuration = $plug->get('settings');
if (!isset($configuration['name']))
	$configuration['name'] = $plug->get('name');
$configuration['plugid'] = $_REQUEST['plugid'];
$signature = Typeframe::Registry()->getPluginSignature($plug->get('plug'));
if ($signature) {
	$classname = $signature->className();
	$plugin    = new $classname($configuration);
} else {
	throw new Exception("Plugin '{$plug->get('plug')}' does not have a signature");
}

// process form
if ('POST' == $_SERVER['REQUEST_METHOD'])
{
	$plugin->update($_POST);
	Typeframe::Registry()->purgeRegistryCache();

	// done
	$redirect = trim(@$_REQUEST['postredir']);
	if (!Typeframe::CurrentPage()->redirected())
	{
		Typeframe::Redirect('Plugin updated.', (empty($redirect) ?
					($typef_app_dir . ((strlen($skin) > 0) ?
					"?skin=$skin" : '')) : $redirect));
	}
	return;
}


// add plugin id, name, settings to template
$pm->setVariable('plugid',         $plugid);
$pm->setVariable('plugname',       $plug->get('plug'));
$pm->setVariable('settings', $plug->get('settings'));
/*$tmp = new Pagemill_Stream();
$plugin->admin($pm->root(), $tmp, new Pagemill_Tag(''));
$pm->setVariable('pluginsettings', $tmp->peek());*/
