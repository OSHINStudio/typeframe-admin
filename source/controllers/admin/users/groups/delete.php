<?php
/*
	User Group Admin delete controller
*/

if ('POST' == $_SERVER['REQUEST_METHOD'])
{
	// save typing below
	$typef_app_dir = (TYPEF_WEB_DIR . '/admin/users/groups');

	// get and validate user group id
	$usergroupid = @$_REQUEST['usergroupid'];
	$usergroup   = Model_Usergroup::Get($usergroupid);
	if (!$usergroup->exists())
	{
		Typeframe::Redirect('No user group provided.', $typef_app_dir, 1);
		return;
	}
	if (in_array($usergroupid, array(TYPEF_DEFAULT_USERGROUPID, TYPEF_ADMIN_USERGROUPID)))
	{
		Typeframe::Redirect('Unable to delete primary user groups.', $typef_app_dir, -1);
		return;
	}
	$users = new Model_User();
	$users->where('usergroupid = ?', $usergroupid);
	if ($users->count() > 0)
	{
		Typeframe::Redirect('Unable to delete a group containing users. Delete the users or move them to a different group first.', $typef_app_dir, -1);
		return;
	}

	// delete application associations
	/*$ugadmin = UserGroupAdmin::DAOFactory();
	$ugadmin->select()->where('usergroupid = ?', $usergroupid);
	foreach ($ugadmin->getAll() as $uga)
		$uga->delete();*/

	// delete the user group
	$usergroup->delete();

	// done
	Typeframe::Redirect('User group deleted.', $typef_app_dir);
	return;
}
