<?php
if (Typeframe::Allow(TYPEF_WEB_DIR . '/admin/users')) {
	// get number of users online
	$users = new Model_User();
	$users->where('DATE_ADD(lastrequest, INTERVAL 30 MINUTE) > NOW()');
	$data = $pm->data();
	$data['admin_users'] = array();
	$data['admin_users']['online'] = $users;
	$pm->addLoop('admin_panels', array(
		'name' => 'Users',
		'template' => '/admin/users/panel.inc.html'
	));
}
