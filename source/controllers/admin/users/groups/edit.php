<?php
$usergroup = Model_Usergroup::Get($_REQUEST['usergroupid']);
if ($usergroup->exists()) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include('update.inc.php');
		Typeframe::Redirect('User group updated.', Typeframe::CurrentPage()->applicationUri() . '/groups');
	} else {
		$pm->setVariable('usergroup', $usergroup);
		$admin = new BaseModel_UsergroupAdmin();
		$admin->where('usergroupid = ?', $usergroup['usergroupid']);
		$apps = array();
		foreach ($admin->select() as $a) {
			$apps[] = $a['application'];
		}
		$pm->setVariable('admin_applications', $apps);
		include('form.inc.php');
	}
} else {
	
}
