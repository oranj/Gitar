<?php

namespace Roto;

$repo = $this->param('repo');
$repo_path = Service::CFG()->repo['root'].$repo.'/';

# sdrop($this->parameters());

$git_path = $repo_path.'.git/';
if (! is_dir($git_path)) {
	throw new \Exception("Attempting to access non git directory: $git_path");
}

chdir($repo_path);

$View->repo_name = $repo;
$View->branch_list = array_filter(array_map(function($string) {
	return trim(ltrim($string, '* '));
}, explode("\n", shell_exec('git branch'))));
