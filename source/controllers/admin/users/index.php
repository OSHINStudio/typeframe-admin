<?php
$users = new Model_User();

// set up search filter, if any
$searchfield = trim(@$_REQUEST['searchfield']);
$searchrange = trim(@$_REQUEST['searchrange']);
$searchquery = trim(@$_REQUEST['searchquery']);
$pm->setVariable('searchfield', $searchfield);
$pm->setVariable('searchrange', $searchrange);
$pm->setVariable('searchquery', $searchquery);
if (!empty($searchquery))
{
	$pm->setVariable('searched', true);

	// filter users using given criteria
	$field = (('email'  == $searchfield) ? $searchfield     : 'username');
	$what  = (('starts' == $searchrange) ? "{$searchquery}%" : "%{$searchquery}%");
	$users->where("{$field} LIKE ?", $what);
}

// set up pagination
$page = trim(@$_REQUEST['page']);
if (!ctype_digit($page)) $page = 1;
$perpage      = 20;
$totalresults = $users->getTotal();
$totalpages   = max(ceil($totalresults / $perpage), 1);
$limit        = (($page - 1) * $perpage);
$pagedurl     = sprintf((TYPEF_WEB_DIR . '/admin/users?searchfield=%s&searchrange=%s&searchquery=%s'),
							urlencode($searchfield), urlencode($searchrange), urlencode($searchquery));
$pm->setVariable('page',       $page);
$pm->setVariable('totalpages', $totalpages);
$pm->setVariable('pagedurl',   $pagedurl);

// set up limits
$users->limit("$limit, $perpage");

// add users and their count to the template
$pm->setVariable('users',        $users);
$pm->setVariable('totalresults', $totalresults);
