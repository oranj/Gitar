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
					'log' => $log_data,
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
	$output = array('message' => array(), 'data' => array());
	$lines = explode("\n", $log);
	foreach ($lines as $line) {
		$is_indented = (substr($line, 0, 4) == '    ');
		if ($is_indented) {
			$output['message'] []= trim($line);
		} else if (preg_match('/^commit (?P<hash>[a-zA-Z0-9]+)$/', $line, $matches)) {
			$output['commit'] = trim($matches['hash']);
		} else if (preg_match('/^(?P<key>[a-zA-Z]*?):\w*(?P<value>.*)$/', $line, $matches)) {
			$output[$matches['key']] = trim($matches['value']);
		}
		$output['data'] []= $line;
	}

	if (isset($output['Date'])) {
		$output['timestamp'] = strtotime($output['Date']);
	} else {
		$output['timestamp'] = null;
	}

	$output['author_name'] = null;
	$output['author_gravatar'] = null;
	if (isset($output['Author'])) {
		if (preg_match('/^(?P<author>.+?) \<(?P<email>.+)\>$/', $output['Author'], $matches)) {

			$output['author_name'] = $matches['author'];
			$output['author_gravatar'] = md5(strtolower(trim($matches['email'])));
		} else {
			$output['author_name'] = $output['Author'];
		}
	}


	return $output;

}

function getCommitCount($repo_path, $branch) {
	chdir($repo_path);
	$count = shell_exec("git rev-list HEAD --count");
	return $count;
}

function getLogs($repo_path, $branch, $start_from = 0, $limit = 20) {
	chdir($repo_path);
	$logs = shell_exec($cmd="git log $branch -$limit --skip=$start_from");
	$lines = explode("\n", $logs);

	$log_buffer = array();
	$line_buffer = array();//array('message' => array(), 'data' => array());
	$was_indented = false;
	foreach ($lines as $line) {
		$is_indented = (substr($line, 0, 4) == '    ');
		if (! $is_indented && $was_indented) {
			$log_buffer []= parseLog(join("\n", $line_buffer));
			$line_buffer = array();
		}
		$line_buffer []= $line;
		$was_indented = $is_indented;
	}


	return $log_buffer;
}

function getFileDiff($repo_path, $commit, $file) {
	chdir($repo_path);
	$list = shell_exec("git diff ${commit}^..${commit} -- $file");
	$lines = explode("\n", $list);

	$in_change = false;
	$out = array();

	$oldline = null;
	$newline = null;

	foreach ($lines as $line) {
		if (! $in_change) {
			if (preg_match('/^@@ \-(?P<oldline>[0-9]+),(?P<oldlength>[0-9]+) \+(?P<newline>[0-9]+),(?P<newlength>[0-9]+) @@/', $line, $matches)) {

				$oldline = $matches['oldline'];
				$newline = $matches['newline'];

				$in_change = true;
			}
		} else if (strlen($line) && $line[0] == '+') {
			$out[] = array(
				'status' => 'add',
				'newlineno' => $newline,
				'oldlineno' => $oldline,
				'line' => substr($line, 1)
			);
			$newline++;
		} else if (strlen($line) && $line[0] == '-') {
			$out[] = array(
				'status' => 'remove',
				'newlineno' => $newline,
				'oldlineno' => $oldline,
				'line' => substr($line, 1)
			);
			$oldline++;
		} else {
			$out[] = array(
				'status' => '',
				'newlineno' => $newline,
				'oldlineno' => $oldline,
				'line' => substr($line, 1)
			);
			$newline++;
			$oldline++;
		}
	}

	return $out;
}

function getCommitModifiedFiles($repo_path, $commit) {
	chdir($repo_path);
	$list = shell_exec("git show --pretty=\"format:\" --name-only $commit");
	return array_values(array_filter(explode("\n", $list)));
}

function getFileInformation($repo_path, $branch, $file_path) {
	if (file_exists($repo_path) && is_dir($repo_path)) {
		chdir($repo_path);
		return shell_exec("git show $branch:$file_path");
	}
	return null;
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
			'log' => $log_data,
			'title' => $branch
		);
	}

	return $output;

}