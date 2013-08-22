<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if ( (!$_SESSION['typef_ftp_user']) || (!$_SESSION['typef_ftp_pass']) ) {
	if ( (defined('TYPEF_FTP_USER')) && (TYPEF_FTP_USER != '') ) {
		$_SESSION['typef_ftp_user'] = TYPEF_FTP_USER;
		$_SESSION['typef_ftp_pass'] = TYPEF_FTP_PASS;
	} else {
		$pm->setVariable('redirect', $_SERVER['REQUEST_URI']);
		Typeframe::SetPageTemplate('/admin/ftp/login.html');
	}
}
?>