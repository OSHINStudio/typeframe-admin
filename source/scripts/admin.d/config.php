<?php
if (Typeframe::Allow(TYPEF_WEB_DIR . '/admin/config')) {
	$admin_config = array();
	foreach (Typeframe::Registry()->configs() as $config) {
		$admin_configs[] = array('name' => $config->name());
	}
	$pm->setVariable('admin_configs', $admin_configs);
	$pm->sortLoop('admin_configs', 'name');
}
