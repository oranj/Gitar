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

$View->breadcrumbs = \Roto\Widget::Breadcrumbs(array(
	'links' => array(
		array('path' => '/'.$repo, 'base' => $repo)
	)
));