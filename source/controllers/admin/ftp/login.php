<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if ($_POST['cmd'] == 'login') {
	$ftp = new Ftp();
	if (!$ftp->connect(TYPEF_FTP_HOST)) {
		Typeframe::Log("Failed to connect to FTP at '" . TYPEF_FTP_HOST . "'");
		$pm->addLoop('errors', array('message' => "Could not connect to '" . TYPEF_FTP_HOST . "'"));
	} else {
		if (!$ftp->login($_POST['username'], $_POST['password'])) {
			Typeframe::Log('FTP login failed');
			$pm->addLoop('errors', array('message' => "Login failed."));
		} else {
			Typeframe::Log('FTP login succeeded');
			$_SESSION['typef_ftp_user'] = $_POST['username'];
			$_SESSION['typef_ftp_pass'] = $_POST['password'];
			Typeframe::Redirect('FTP login confirmed.', $_POST['redirect']);
			return;
		}
	}
	$pm->setVariable('redirect', $_POST['redirect']);
}
?>