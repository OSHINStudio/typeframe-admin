<?php
/**
 * Typeframe Plugin application
 *
 * admin index controller
 */

// load plugins; add to template
$plugins = new Model_Plug();
$plugins->order('name, plug, plugid');
$pm->setVariable('plugins', $plugins);

// add skins to template
$skins = array();
foreach (glob((TYPEF_DIR . '/skins/*'), GLOB_ONLYDIR) as $directory)
	$skins[] = basename($directory);
$pm->setVariable('skins', $skins);

// set skin; add to template
$skin = trim(@$_REQUEST['skin']);
$skin = ((strlen($skin) > 0) ? $_REQUEST['skin'] : (TYPEF_SITE_SKIN ? TYPEF_SITE_SKIN : 'default'));
if (!in_array($skin, $skins))
{
	Typeframe::Redirect("'$skin' was not found in the skins directory.", TYPEF_WEB_DIR . '/admin/skins');
	return;
}
$pm->setVariable('skin', $skin);

// load sockets
$plugins = array();
$sockets = new Model_PlugLoc();
$sockets->where('skin = ?', $skin);
$sockets->order('socket, sortnum');
foreach ($sockets->getAll() as $socket)
{
	if (!isset($plugins[$socket->get('socket')]))
		$plugins[$socket->get('socket')] = array();

	$plugins[$socket->get('socket')][] = $socket;
}

// define skin file
$skinfile = (TYPEF_DIR . '/skins/' . $skin . '/skin.html');
if (!file_exists($skinfile))
	$skinfile = (TYPEF_DIR . '/skins/default/skin.html');

// load sockets for skin file
$source = file_get_contents($skinfile);
foreach (get_html_translation_table() as $character => $entity)
{
	if (($entity != '&amp;') && ($entity != '&quot;') && ($entity != '&gt;') && ($entity != '&lt;'))
		$source = str_replace($entity, ' ', $source);
}
$xml     = Pagemill_SimpleXmlElement::LoadString($source);
$sockets = $xml->xpath('//pm:socket');

// add sockets to template
foreach ($sockets as $socket)
{
	$name   = "{$socket['for']}";
	$socket = array('socket' => $name);
	if (isset($plugins[$name]))
		$socket['plugins'] = $plugins[$name];
	$pm->addLoop('sockets', $socket);
}
