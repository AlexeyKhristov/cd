<?php

require('NotusFlow.php');

$output = '';
$error = '';
$info = '';

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

try {

	switch(strtolower($_POST['action'])) {
		case 'changebranch':
			$output = $flow->changeBranch($_POST['branch']);
			$flow->pullRepo();
			$flow->clearDiskCache();
			$info = "Branch changed";
			break;
		case 'gitpull':
			$output = $flow->pullRepo();
			$info = "git pull finished successfully";
			break;
		case 'clearcache':
			$output = $flow->clearDiskCache();
			$output .= "./concat_files.sh && rm core/cache/*";
			$info = "Cache cleared";
			break;
	}
} catch (Exception $e) {
	$error = $e->getMessage();
}

require('template.php');