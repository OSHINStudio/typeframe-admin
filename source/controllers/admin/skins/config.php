<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

if (!$_REQUEST['skin']) {
	Typeframe::Redirect('No skin directory specified.', Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}
if (!is_dir(TYPEF_DIR . '/skins/' . $_REQUEST['skin'])) {
	Typeframe::Redirect('Invalid skin directory specified.', Typeframe::CurrentPage()->applicationUri(), 1);
	return;
}
if (!file_exists(TYPEF_DIR . "/skins/{$_REQUEST['skin']}/config.xml")) {
	Typeframe::Redirect("The '{$_REQUEST['skin']}' skin is not configurable.", Typeframe::CurrentPage()->applicationUri(), 1);
	return;	
}
$xml = simplexml_load_file(TYPEF_DIR . "/skins/{$_REQUEST['skin']}/config.xml");
if ($_REQUEST['cmd'] == 'config-update') {
	$rs = $db->prepare('DELETE FROM #__skin_config WHERE skin = ?');
	$rs->execute($_REQUEST['skin']);
	$rs = $db->prepare('REPLACE INTO #__skin_config SET skin = ?, configname = ?, configvalue = ?');
	foreach ($xml->item as $c) {
		$rs->execute($_REQUEST['skin'], "{$c['name']}", $_REQUEST["{$c['name']}"]);
	}
	if ($_REQUEST['continue']) {
		$redirect = TYPEF_WEB_DIR . '/admin/skins/configure?edit=' . $_REQUEST['skin'];
	} else {
		$redirect = TYPEF_WEB_DIR . '/admin/skins';
	}
	Typeframe::Redirect('Skin configuration updated.', $redirect, 1);
	return;
}
$rs = $db->prepare('SELECT * FROM #__skin_config WHERE skin = ?');
$rs->execute($_REQUEST['skin']);
$settings = array();
while ($row = $rs->fetch_array()) {
	$settings[$row['configname']] = $row['configvalue'];
}
foreach($xml->item as $c) {
	$item = array();
	$item['caption'] = "{$c['caption']}";
	$item['configname'] = "{$c['name']}";
	$item['configvalue'] = $settings["{$c['name']}"];
	$item['type'] = "{$c['type']}";
	$pm->addLoop('items', $item);
}
$pm->setVariable('skin', $_REQUEST['skin']);
?>