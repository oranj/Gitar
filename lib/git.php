<?php

function getRepoInformation($directory) {
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

				$date = null;
				if (preg_match('/\bDate: (.*?)\n/', $log, $matches)) {
					$date = strtotime($matches[1]);
				}


				$output[$repo_name] = array(
					'log' => $log,
					'date' => $date,
					'url' => 'git@10.28.6.12:repos/'.$repo,
					'title' => $repo_name,
					'repo' => $repo
				);
			}

		}
	}

	return $output;


}
