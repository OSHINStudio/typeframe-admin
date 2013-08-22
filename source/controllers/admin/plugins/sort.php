<?php
/**
 * Change the order of plugins in a socket.
 */
$typef_app_dir = Typeframe::CurrentPage()->applicationUri();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['locid']) || !is_array($_POST['locid'])) {
		Typeframe::Redirect('Invalid socket plugin ids.', $typef_app_dir);
	} else {
		$sortnum = 1;
		foreach ($_POST['locid'] as $locid) {
			$plugloc = Model_PlugLoc::Get($locid);
			$plugloc->set('sortnum', $sortnum);
			$plugloc->save();
			++$sortnum;
		}
		Typeframe::Redirect('Plugins sorted.', $typef_app_dir);
	}
} else {
	Typeframe::Redirect('Nothing to do.', $typef_app_dir);
}
