<?php

function getRepoInformation($directory, $repoWebRoot) {
	$repos = scandir($directory);
	$output = array();

	foreach ($repos as $repo) {
		if (trim($repo, '.')) {
			$fullPath = $directory.$repo;
			if (is_dir ($fullPath)) {
				if ( ! is_dir($fullPath.'/.git') && ! file_exists($fullPath.'/HEAD')) {
					continue;
				}

				$repo_name = str_replace('.git', '', $repo);
				chdir($fullPath);

				$log = `git log --all -1`;
				$log_data = parseLog($log);


				$output[strtolower($repo_name)] = array(
					'log' => $log,
					'date' => $log_data['date'],
					'url' => $repoWebRoot.$repo,
					'title' => $repo_name,
					'repo' => $repo
				);
			}
		}
	}

	ksort($output);

	return $output;
}

function parseLog($log) {
	$date = null;
	if (preg_match('/\bDate: (.*?)\n/', $log, $matches)) {
		$date = strtotime($matches[1]);
	}
	return array(
		'date' => $date
	);

}

function getLogs($repo_path, $branch, $start_from = 0, $limit = 20) {
	chdir($repo_path);
	$logs = shell_exec($cmd="git log $branch -$limit --skip=$start_from");
#	drop($cmd);
	$lines = explode("\n", $logs);

	$log_buffer = array();
	$line_buffer = array('message' => array(), 'data' => array());
	$was_indented = false;
	foreach ($lines as $line) {
		$is_indented = (substr($line, 0, 4) == '    ');
		if (! $is_indented && $was_indented) {
			$log_buffer []= $line_buffer;
			$line_buffer = array(
				'message' => array(),
				'data' => array()
			);
		}

		if ($is_indented) {
			$line_buffer['message'] []= trim($line);
		} else if (preg_match('/^commit (?P<hash>[a-zA-Z0-9]+)$/', $line, $matches)) {
			$line_buffer['commit'] = trim($matches['hash']);
		} else if (preg_match('/^(?P<key>[a-zA-Z]*?):\w*(?P<value>.*)$/', $line, $matches)) {
			$line_buffer[$matches['key']] = trim($matches['value']);
		}

		$line_buffer['data'] []= $line;

		$was_indented = $is_indented;
	}

	return $log_buffer;
}

function getBranchInformation($repo_path) {
	$output = array();

	chdir($repo_path);
	$branches = array_filter(array_map(function($string) {
		return trim(ltrim($string, '* '));
	}, explode("\n", shell_exec('git branch'))));

	foreach ($branches as $branch) {
		$log = shell_exec("git log $branch -1");
		$log_data = parseLog($log);

		$output[$branch] = array(
			'log' => $log,
			'date' => $log_data['date'],
			'title' => $branch
		);
	}

	return $output;

}