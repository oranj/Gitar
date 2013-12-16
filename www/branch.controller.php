<?php

namespace Roto;

$repo = $this->param('repo');
$repo_path = Service::CFG()->repo['root'].$repo.'/';

# sdrop($this->parameters());

$git_path = $repo_path.'.git/';
if (! is_dir($git_path) && ! file_exists($repo_path.'HEAD')) {
	throw new \Exception("Attempting to access non git directory: $git_path");
}
require_once('lib/git.php');

$View->repo_name = $repo;
$branch_list = getBranchInformation($repo_path);

$autoloadBranch = null;
if (count($branch_list) == 1) {
	$autoloadBranch = key($branch_list);
} else if (isset($branch_list['master'])) { 
	$autoloadBranch = 'master';
} else {	
	$latest = null;
	foreach ($branch_list as $branch => $data) {
		if ((! $latest) || ((int)($data['log']['timestamp']) > (int)($latest['log']['timestamp']))) {
			$latest = $data;
		}
	}
	if ($latest) {
		$autoloadBranch = $latest['title'];
	}
}


$View->branch_list = $branch_list;

if ($this->param('option') == 'auto') {
	if (isset($autoloadBranch)) {
		header( sprintf( "Location: /%s/%s/", $repo, $autoloadBranch  ) );	
	} else {
		header( sprintf( "Location: /%s/", $repo));
	}
	exit;
}

$View->breadcrumbs = \Roto\Widget::Breadcrumbs(array(
	'links' => array(
		array('path' => '/'.$repo, 'base' => $repo)
	)
));
