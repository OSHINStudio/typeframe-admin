<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();
Typeframe::SetPageTemplate('/admin/skins/index.html');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$skins = array('TYPEF_SITE_SKIN', 'TYPEF_ADMIN_SKIN', 'TYPEF_MOBILE_SITE_SKIN', 'TYPEF_MOBILE_ADMIN_SKIN');
	$key = $_POST['config'];
	if (in_array($key, $skins)) {
		$config = Model_Config::Get($key);
		if ($config->exists()) {
			$config['configvalue'] = $_POST['skin'];
		} else {
			$config = Model_Config::Create();
			$config['configname'] = $key;
			$config['configvalue'] = $_POST['skin'];
		}
		$config->save();
		Typeframe::Registry()->purgeRegistryCache();
	}
	Typeframe::Redirect('Skins updated.', Typeframe::CurrentPage()->applicationUri());
	return;
}
foreach (Typeframe::GetSkins() as $skin) {
	$row = array();
	$row['skin'] = $skin;
	if (file_exists(TYPEF_DIR . "/skins/{$skin}/config.xml")) {
		$row['configurable'] = true;
	} else {
		$row['configurable'] = false;
	}
	$pm->addLoop('skins', $row);
}
$pm->setVariable('typef_site_skin', TYPEF_SITE_SKIN);
$pm->setVariable('typef_admin_skin', TYPEF_ADMIN_SKIN);
$pm->setVariable('typef_use_mobile_skins', TYPEF_USE_MOBILE_SKINS);
$pm->setVariable('typef_mobile_site_skin', TYPEF_MOBILE_SITE_SKIN);
$pm->setVariable('typef_mobile_admin_skin', TYPEF_MOBILE_ADMIN_SKIN);
