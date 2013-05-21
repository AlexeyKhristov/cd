<?php

require('NotusFlow.php');

$output = '';

$flow = new NotusFlow();
//var_dump($flow->getBranches());
//var_dump($flow->getCurrentBranch());
//$flow->fetchRepo();
//$flow->changeBranch('master');
//$flow->pullRepo();
//$flow->clearDiskCache();

if (!isset($_POST['action'])) {
	require('template.php');
	exit;
}

switch(strtolower($_POST['action'])) {
	case 'changebranch':
		$output = $flow->changeBranch($_POST['branch']);
		$output .= "\nBranch changed";
		break;
	case 'gitpull':
		$output = $flow->pullRepo();
		$output .= "\ngit pull finished ok";
		break;
	case 'clearcache':
		$output = $flow->clearDiskCache();
		$output .= "rm core/cache/*\n";
		$output .= "./concat_files.sh";
		break;
}

require('template.php');