<?php
/**
 * Delete a plugin and remove it from all locations.
 */

// save typing below
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();

// requires POST
if ('POST' != $_SERVER['REQUEST_METHOD']) {
	Typeframe::Redirect('Nothing to do.', $typef_app_dir);
	return;
}

// get and validate plugin id
$plugid = trim(@$_POST['plugid']);
$plug   = Model_Plug::Get($plugid);
if (!$plug->exists()) {
	Typeframe::Redirect('Invalid plugin id.', $typef_app_dir);
	return;
}
// delete any locations that use this plugin
$plug_locs = new Model_PlugLoc();
$plug_locs->where('plugid = ?', $plugid);
foreach ($plug_locs->getAll() as $plug_loc)
	$plug_loc->delete();

// delete the plugin itself
$plug->delete();

// done
Typeframe::Redirect('Plugin deleted.', "$typef_app_dir?skin={$_POST['skin']}");
