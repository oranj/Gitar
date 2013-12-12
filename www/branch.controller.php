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
$View->branch_list = getBranchInformation($repo_path);

$autoloadBranch = null;
if (count($View->branch_list) == 1) {
	$autoloadBranch = key($View->branch_list);
} else if (isset($View->branch_list['master'])) { 
	$autoloadBranch = 'master';
}

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
