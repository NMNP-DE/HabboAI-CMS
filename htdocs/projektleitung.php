<?php

header('Content-Type: text/html; charset=UTF-8');
require ('./inc/base.inc.php');
require ('./inc/maintenance.inc.php');

if(LOGGING_IN == false){
    header('location: '. $_CONFIG['website']['url']);
}

//if($user->UserData('rank') <= 9){ header('location: '. $_CONFIG['website']['url'] .'/client');}
$userstaff = dbSelect('*', 'users', "WHERE rank >= '" . $_CONFIG['community']['stafflist'] . "' ORDER BY rank DESC");
if($userstaff->num_rows > 0) {
	while ($row = $userstaff->fetch_array()) {
		$tpl->block_assign('userstaff', array(
			'USERRANK'		=>	$row['rank'],
			'USERNAME'		=>	$row['username'],
			'USERLOOK'		=>	$row['look'],
			'USERID'		=>	$row['id'],
			'USERWORKING'	=>	$row['working'],
			'USERONLINE'	=>	$row['online'],
			'USERMOTTO'	=>	$row['motto'],
			'USERLONLINE'	=>	$core->lasttimeword($row['last_online'])
		));
	}
}
$newusers = dbSelect('*', 'users', "WHERE rank > 0 ORDER BY id DESC LIMIT 1");
while ($row = $newusers->fetch_array()) {
	$tpl->block_assign('newusers', array(
		'ID'		=>	$row['id'],
		'USERNAME'	=>	$row['username'],
		'USERLOOK'	=>	$row['look'],
		'USERONLINE'=>	$row['online'],
		'USERMOTTO' => 	$row['motto'],
		'USERLAST'	=>	$core->lasttimeword($row['last_online'])
	));
}

$tpl->assign(array(
	'MENU'		=> '2',
	'NEWS'		=> '0',
	'SEITE'		=>	"Projektleitung",
	'ABMOD'		=>	($_CONFIG['community']['stafflist']+2),
	'ABEXP'		=>	($_CONFIG['community']['stafflist']),
	'ABDJ'		=>	($_CONFIG['community']['stafflist']+1)
	
));

$tpl->display($user->UserData('theme').'/page-projektleitung');

?>