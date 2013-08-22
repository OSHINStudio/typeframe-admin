<?php
/**
 * Typeframe Config application
 *
 * admin index controller
 */

foreach (Typeframe::Registry()->configs() as $config)
	$pm->addLoop('configs', array('name' => $config->name()));
$pm->sortLoop('configs', 'name');
?>