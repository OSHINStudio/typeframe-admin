<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if ( (!$_REQUEST['skin']) || (!$_REQUEST['stylesheet']) ) {
	Typeframe::Redirect('Skin and/or stylesheet not specified.', Typeframe::CurrentPage()->applicationUri(), 1);
}
$pm->setVariable('skin', $_REQUEST['skin']);
$pm->setVariable('stylesheet', $_REQUEST['stylesheet']);
if (file_exists(TYPEF_DIR . "/skins/{$_REQUEST['skin']}{$_REQUEST['stylesheet']}")) {
	$pm->setVariable('source', file_get_contents(TYPEF_DIR . "/skins/{$_REQUEST['skin']}{$_REQUEST['stylesheet']}"));
} else if (file_exists(TYPEF_DIR . "/skins/default{$_REQUEST['stylesheet']}")) {
	$pm->setVariable('source', file_get_contents(TYPEF_DIR . "/skins/default{$_REQUEST['stylesheet']}"));
} else {
	Typeframe::Redirect('Stylesheet does not exist.', Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}
if ($_POST['cmd'] == 'stylesheet-update') {
	$ftp = new FTP();
	if (!$ftp->connect(TYPEF_FTP_HOST)) {
		Typeframe::Redirect('Unable to connect to FTP server.', Typeframe::CurrentPage()->applicationUri(), -1);
		return;
	}
	if (!$ftp->login($_SESSION['typef_ftp_user'], $_SESSION['typef_ftp_pass'])) {
		Typeframe::Redirect('Unable to log into FTP server.', Typeframe::CurrentPage()->applicationUri(), -1);
		return;
	}
	$h = tmpfile();
	fwrite($h, $_REQUEST['source']);
	if (!fflush($h)) die("Failed to flush");
	rewind($h);
	// Make sure that all required directories exist
	$dirs = dirname("{$_REQUEST['skin']}{$_REQUEST['stylesheet']}");
	$dirnames = split("/", $dirs);
	$localpath = TYPEF_DIR . '/skins';
	$curdir = '';
	for ($i = 0; $i < count($dirnames); $i++) {
		$curdir .= '/' . $dirnames[$i];
		if (!file_exists("{$localpath}{$curdir}")) {
			echo "Making /skins{$curdir}<br/>";
			$ftp->mkdir(TYPEF_FTP_ROOT . "/skins{$curdir}");
		}
	}
	$ftp->fput(TYPEF_FTP_ROOT . "/skins/{$_REQUEST['skin']}{$_REQUEST['stylesheet']}", $h, FTP_ASCII);
	$ftp->close();
	fclose($h);
	Typeframe::Redirect("Stylesheet updated.", Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}
?>