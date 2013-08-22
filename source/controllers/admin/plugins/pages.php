<?php
/**
 * Manage the pages where a plugin appears.
 */

// validate plugin location id
$plug_loc = Model_PlugLoc::Get($_REQUEST['locid']);
if (!$plug_loc->exists())
	Bam_Json::FailureOrRedirect('Invalid socket plugin id.', $typef_app_dir);

// process form
if ('POST' == $_SERVER['REQUEST_METHOD'])
{
	// TODO: Handle empty rules array (assuming "all" for now)
	$rules = '';
	if (empty($_POST['allpages']) && isset($_POST['rules']))
	{
		$allExcludes = true;
		foreach ($_POST['rules'] as $rule)
		{
			if (substr($rule, 0, 1) != '!')
				$allExcludes = false;
		}
		$rules = implode(';', $_POST['rules']);
		if ($allExcludes) $rules = "url:*;$rules";
	}
	else
	{
		$rules = 'url:*';
	}

	$plug_loc = Model_PlugLoc::Get($_POST['locid']);
	$plug_loc->set('rules', $rules);
	$plug_loc->save();

	Typeframe::Redirect('Plugin location updated.', TYPEF_WEB_DIR . '/admin/plugins?skin=' . $row['skin']);
	return;
}

// add plugin location to template
$pm->setVariable('plugin', $plug_loc);

// define enterprise children, root
if (TYPEF_ENT)
{
	$children = TypeframeEnterpriseChild::DAOFactory();
	$children = $children->getAll();
	array_unshift($children, TypeframeEnterprise::GetChild(0));

	// add to template
	foreach ($children as $child)
	{
		$pm->addLoop('children', array
		(
			'id'   => $child->get('id'),
			'name' => (TYPEF_ENT_CHILD_NAME . ' ' . $child->get('childname'))
		));
	}
}

// break down rules; add to template
$rules = explode(';', $plug_loc->get('rules'));
foreach ($rules as $rule)
{
	list($type, $code) = explode(':', $rule);

	if (substr($type, 0, 1) == '!')
	{
		$desc = 'Exclude from ';
		$type = substr($type, 1);
	}
	else
	{
		$desc = 'Include on';
	}

	if (('url' == $type) && ('*' == $code))
	{
		if (count($rules) == 1)
		{
			$pm->setVariable('allpages', true);
			continue;
		}

		$desc .= ' all pages';
	}
	else
	{
		switch ($type)
		{
			case 'url':
				$desc .= " $code";
			break;
			case 'child':
				// child mode is only available in enterprise mode
				if (!TYPEF_ENT) continue 2;

				// look up child
				foreach ($children as $child)
				{
					if ($child->get('id') == $code)
					{
						$desc .= (' ' . TYPEF_ENT_CHILD_NAME . ' ' . $child->get('childname'));
						break 2;
					}
				}
			break;
			case 'pid':
				$page = Model_Page::Get($code);
				if (!$page->exists()) continue 2;

				$desc .= (' ' . ($page->get('nickname') ? $page->get('nickname') : $page->get('uri')));
			break;
			default:
				continue 2;
			break;
		}
	}
	$pm->addLoop('rules', array('code' => $rule, 'description' => $desc));
}

// get all pages for this skin
$pages = new Model_Page();
//$pages->where('skin = ?', $plug_loc->get('skin'));
//if (TYPEF_SITE_SKIN == $plug_loc->get('skin'))
//	$pages->orWhere('skin = ?', '');
$pages->order('nickname, uri');

// add pages to template
$pm->setVariable('pages', $pages);
