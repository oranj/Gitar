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


				$output[$repo_name] = array(
					'log' => $log,
					'date' => $log_data['date'],
					'url' => $repoWebRoot.$repo,
					'title' => $repo_name,
					'repo' => $repo
				);
			}

		}
	}

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