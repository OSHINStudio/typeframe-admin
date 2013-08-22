<?php
/**
 * Remove a plugin from a socket.
 */
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$locid = trim(@$_POST['locid']);
	$plug_loc = Model_PlugLoc::Get($locid);
	if ($plug_loc->exists()) {
		$plug_loc->delete();
		Typeframe::Redirect('Plugin removed from socket.', $typef_app_dir);
	} else {
		Typeframe::Redirect('Invalid location specified.', $typef_app_dir);
	}
} else {
	Typeframe::Redirect('Nothing to do.', $typef_app_dir);
}
