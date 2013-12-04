<?php

namespace Roto;

$View->repo = $repo = $this->param('repo');
$View->branch = $branch = $this->param('branch');
$View->repo_path = $repo_path = Service::CFG()->repo['root'].$repo.'/';
$View->file_path = $this->param('filepath');

$file_path = $View->file_path ?: "./";
$View->is_file = $file_path[strlen($file_path)-1] !== '/';


if (file_exists($repo_path) && is_dir($repo_path)) {
	chdir($repo_path);
	$out = shell_exec($cmd = "git show $branch:$file_path");
	if ($View->is_file) {
		$View->file_contents = $out;
	} else {
		$contents = array_filter(explode("\n", $out));
		unset($contents[0]);
		$View->dir_contents = $contents;
	}
}
