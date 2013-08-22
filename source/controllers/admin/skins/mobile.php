<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	Model_Config::Set('TYPEF_USE_MOBILE_SKINS', $_POST['enable']);
	Typeframe::Registry()->purgeRegistryCache();
}
