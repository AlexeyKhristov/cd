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

	private function _getRawRemoteBranches() {
		$out = array();
		$ret = 0;
		exec('git branch --remotes', $out, $ret);

		if ($ret !== 0)
			throw new Exception('git branch return error');

		return $out;
	}

	private function _runCommand($command) {
		$out = array();
        $ret = 0;
        exec($command, $out, $ret);

        if ($ret !== 0)
            throw new Exception("Command '$command' return an error: " . implode("\n", $out));

        return $out;
	}

	public function getBranches() {
		$result = array();
		$branches = $this->_getRawRemoteBranches();

		foreach($branches as $branch) {

			if (strpos($branch, 'HEAD') !== false)
				continue;
			if (strpos($branch, 'old_origin') !== false)
				continue;

			if (stripos($branch, 'origin/') !== false) {
				$branch = str_replace('origin/', '', $branch);
				$result[] = ltrim($branch, '* ');
			}
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
        exec('git pull 2>&1 && git submodule update 2>&1', $out, $ret);

        if ($ret !== 0)
            throw new Exception('git pull return an error: ' . implode("\n", $out));

        return implode("\n", $out);
	}

	public function changeBranch($newBranch) {
        $out = array();
        $ret = 0;
        exec('git checkout ' . $newBranch . ' 2>&1', $out, $ret);

        if ($ret !== 0)
            throw new Exception('git checkout return an error: ' . implode("\n", $out));

        return implode("\n", $out);
	}

	public function clearDiskCache() {
		$this->_runCommand('cd master && ./vendor/bin/phing deploy');
		// memcached clear
                try {
                        $this->_runCommand('ls ' . $this->_path . '');
                } catch (Exception $e) {
                        return;
                }
		$this->_runCommand('./memcached_clear.sh');
	}
}
