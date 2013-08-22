<?php
/**
 * Typeframe Pages application
 *
 * admin preview controller
 */

// set skin
Typeframe::SetPageSkin($_POST['skin']);

// add content
$pm->setVariable('page_content', $_POST['page_content']);
?>