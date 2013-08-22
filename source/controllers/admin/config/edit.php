<?php
/**
 * Typeframe Config application
 *
 * admin edit controller
 */

Plugin_Breadcrumbs::Add('Edit');

$config = Typeframe::Registry()->getConfig($_REQUEST['config']);
if (!$config)
{
	Typeframe::Redirect('Invalid config specified', Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}

if ($config->redirect()) {
	Typeframe::Redirect('Redirecting to ' . $config->name() . ' admin...', $config->redirect());
	return;
}

// update the config settings
if ('POST' == $_SERVER['REQUEST_METHOD'])
{
	foreach ($config->items() as $i)
	{
		$config = Model_Config::Get($i->name());
		if (!$config->exists()) {
			$config = Model_Config::Create();
			$config['configname'] = $i->name();
		}
		$config['configvalue'] = (isset($_POST[$i->name()]) ? $_POST[$i->name()] : '');
		$config->save();
	}
	Typeframe::Registry()->purgeRegistryCache();
	Typeframe::Redirect('Configuration updated.', Typeframe::CurrentPage()->applicationUri());
	return;
}

// otherwise, set it up to edit
//if ($config->template()) Typeframe::SetPageTemplate($config->template());

$object = new stdClass();
$object->name = $config->name();
$items = array();
foreach ($config->items() as $i)
{
	$items[] = array
	(
		'name'    => $i->name(),
		'caption' => $i->caption(),
		'type'    => $i->type(),
		'default' => $i->defaultValue(),
		'value'   => constant($i->name())
	);
	if ('select' == $i->type())
	{
		$options = array();
		foreach ($i->options() as $o)
		{
			$options[] = array
			(
				'value'   => $o->value(),
				'caption' => $o->caption()
			);
		}
		$items[count($items) - 1]['options'] = $options;
	}
}
$object->items = $items;
$pm->setVariable('config', $object);
