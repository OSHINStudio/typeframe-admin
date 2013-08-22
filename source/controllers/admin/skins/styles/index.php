<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

foreach (Typeframe::GetSkins() as $skin) {
	if ($skin != 'default') {
		$pm->addLoop('skins', array('skin' => $skin));
	}
}
$exists = array();
foreach (Typeframe::Registry()->stylesheets() as $s) {
	if ($s->stylesheet()) {
		if (!in_array($s->stylesheet(), $exists)) {
			$pm->addLoop('stylesheets', array('stylesheet' => $s->stylesheet()));
			array_push($exists, $s->stylesheet());
		}
	}
}
$pm->sortLoop('skins', 'skin');
$pm->sortLoop('stylesheets', 'stylesheet');
?>