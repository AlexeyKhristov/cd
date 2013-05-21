<?php

class NotusFlow {
	private $_path = '/var/www/stage.notus.com.ua';

	public function __construct() {
		chdir($this->_path);
	}

	private function _getRawBranches() {
		$out = array();
		$ret = 0;
		exec('git branch', $out, $ret);

		if ($ret !== 0)
			throw new Exception('git branch return error');

		return $out;
	}

	private function _runCommand($command) {
		$out = array();
                $ret = 0;
                exec($command, $out, $ret);

                if ($ret !== 0)
                        throw new Exception("Command '$command' return an error: ".implode("\n", $out));

                return $out;
	}

	public function getBranches() {
		$result = array();
		$branches = $this->_getRawBranches();

		foreach($branches as $branch) {
			$result[] = ltrim($branch, '* ');
		}
		return $result;
	}

	public function getCurrentBranch() {
		$result = array();
		$branches = $this->_getRawBranches();

                foreach($branches as $branch) {
			if ($branch[0] === '*')
				return ltrim($branch, '* ');
                }
		return '(no branch)';
	}

	public function fetchRepo() {
                $out = array();
                $ret = 0;
                exec('git fetch', $out, $ret);

                if ($ret !== 0)
                        throw new Exception('git fetch return error');
	}

	public function pullRepo() {
                $out = array();
                $ret = 0;
                exec('git pull', $out, $ret);

                if ($ret !== 0)
                        throw new Exception('git fetch return error');
	}

	public function changeBranch($newBranch) {
                $out = array();
                $ret = 0;
                exec('git checkout ' . $newBranch, $out, $ret);

                if ($ret !== 0)
                        throw new Exception('git checkout return error');

	}

	public function clearDiskCache() {
		$o = $this->_runCommand('rm ' . $this->_path . '/core/cache/*');
		var_dump($o);
	}
}

$flow = new NotusFlow();
//var_dump($flow->getBranches());
//var_dump($flow->getCurrentBranch());
$flow->fetchRepo();
$flow->changeBranch('master');
$flow->pullRepo();
$flow->clearDiskCache();

