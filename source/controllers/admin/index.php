<?php
/*
 * Applications can add their own control panels to the Admin index with a
 * script in the source/scripts/admin/index directory.
 *
 * Access to administrable pages (e.g., Content pages) is provided by adding
 * an element to the admin_pages array. The easiest way to add the element is
 * to use a Model_Page record and add the URL to the application's relevant
 * control panel (e.g., ~/admin/content/page?pageid=#).
 *
 * Custom navigation panels can be added to the index through the
 * admin_categories array. Each element should contain two keys: name (the name
 * of the category) and template (the relative path to the template). In the
 * default skin, the category name gets added to a list of tabs and the template
 * gets inserted into the corresponding panel. The application's script can add
 * add data to the Typeframe::Pagemill() object if necessary.
 */

$scripts = scandir(TYPEF_SOURCE_DIR . '/scripts/admin.d');
foreach ($scripts as $script) {
	if (substr($script, 0, 1) != '.') {
		Typeframe::IncludeScript("/admin.d/{$script}");
	}
}
if ($pm->getVariable('admin_pages')) {
	$pm->sortLoop('admin_pages', 'nickname');
}
if ($pm->getVariable('admin_categories')) {
	$pm->sortLoop('admin_categories', 'name');
}
