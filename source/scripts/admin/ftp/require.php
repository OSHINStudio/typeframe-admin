<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if ( (empty($_SESSION['typef_ftp_user'])) || (empty($_SESSION['typef_ftp_pass'])) ) {
	if ( (defined('TYPEF_FTP_USER')) && (defined('TYPEF_FTP_PASS')) && (TYPEF_FTP_USER != '') ) {
		// Test the provided credentials
		$ftp = new Ftp();
		$ftp->connect(TYPEF_FTP_HOST) or die('Invalid FTP host.');
		if ($ftp->login(TYPEF_FTP_USER, TYPEF_FTP_PASS)) {
			$_SESSION['typef_ftp_user'] = TYPEF_FTP_USER;
			$_SESSION['typef_ftp_pass'] = TYPEF_FTP_PASS;
			$ftp->close();
			return;
		}
	}
	$pm->setVariable('redirect', $_SERVER['REQUEST_URI']);
	Typeframe::SetPageTemplate('/admin/ftp/login.html');
	Typeframe::CurrentPage()->stop();
}
