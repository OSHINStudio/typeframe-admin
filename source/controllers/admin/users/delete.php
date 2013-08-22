<?php
if (empty($_REQUEST['userid'])) {
	Typeframe::Redirect('No user specified.', Typeframe::CurrentPage()->applicationUri(), 1);
} else {
	$user = Model_User::Get($_REQUEST['userid']);
	if ($user->exists()) {
		if ($user['userid'] == Typeframe::User()->get('userid')) {
			Typeframe::Redirect('You cannot delete an account while you are logged into it.', Typeframe::CurrentPage()->applicationUri(), -1);
		} else {
			$pm->setVariable('user', $user);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$user->delete();
				Typeframe::Redirect('User deleted.', Typeframe::CurrentPage()->applicationUri());
			}
		}
	}
}
