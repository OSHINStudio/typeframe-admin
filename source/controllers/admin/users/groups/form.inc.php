<?php
foreach (Typeframe::Registry()->pages() as $page) {
	$application = $page->application();
	if ('/admin/' == substr($application->base(), 0, 7)) {
		$pm->addLoop('applications', array
		(
			'application' => $application->name(),
			'title'       => $application->title(),
			'selected'    => in_array($application->name(), $applications)
		));
		++$appcount;
	}
}
$pm->sortLoop('applications', 'application');
