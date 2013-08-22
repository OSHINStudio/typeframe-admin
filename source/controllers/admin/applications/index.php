<?php
$db = Typeframe::Database();
$pm = Typeframe::Pagemill();

Typeframe::SetPageTemplate('/admin/applications/index.html');
foreach (Typeframe::Registry()->applications() as $a) {
	$app = array('name' => $a->name(), 'title' => $a->title(), 'map' => $a->map());
	$pm->addLoop('applications', $app);
	if ($a->map() == 'hard') {
		$pm->addLoop('applications', 'pages', array('uri' => TYPEF_WEB_DIR . $a->base()));
	} else {
		// TODO: Figure out what to do about soft-mapped pages
		/*
		foreach (Typeframe::Registry()->getApplicationPagesByName($a->name()) as $p) {
			$pm->addLoop('applications', 'pages', array('uri' => $p->uri()));
		}
		*/
	}
}
$pm->sortLoop('applications', 'name');
?>