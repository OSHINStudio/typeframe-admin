<?php

$usergroup->setArray($_POST, false);
$usergroup->save();
$perms = new BaseModel_UsergroupAdmin();
$perms->where('usergroupid = ?', $usergroup['usergroupid']);
$perms->deleteQuery();
if (isset($_POST['admin'])) {
	foreach ($_POST['admin'] as $app) {
		$perm = BaseModel_UsergroupAdmin::Create();
		$perm['usergroupid'] = $usergroup['usergroupid'];
		$perm['application'] = $app;
		$perm->save();
	}
}
