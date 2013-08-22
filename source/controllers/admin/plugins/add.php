<?php
/**
 * Create a new plugin.
 */

Plugin_Breadcrumbs::Add('Add');

// save typing below
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();

// process form
if ('POST' == $_SERVER['REQUEST_METHOD'])
{
	$plug = Model_Plug::Create();
	$plug->set('plug',     $_POST['plug']);
	//$plug->set('settings', json_encode((isset($_POST['settings']) && is_array($_POST['settings'])) ? $_POST['settings'] : array()));
	$plug->set('settings', ((isset($_POST['settings']) && is_array($_POST['settings'])) ? $_POST['settings'] : array()));
	$plug->save();

	// done
	$skin = (isset($_REQUEST['skin']) ? "&skin={$_REQUEST['skin']}" : '');
	Typeframe::Redirect('Plugin created.', ("{$typef_app_dir}/edit?plugid=" . $plug->get('plugid') . $skin));
	return;
}

// load plugins; add to template; sort by name
foreach (Typeframe::Registry()->plugins() as $plugin)
{
	$pm->addLoop('plugins', array
	(
		'name' => $plugin->name()
	));
}
$pm->sortLoop('plugins', 'name');
