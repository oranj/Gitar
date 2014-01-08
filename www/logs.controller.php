<?php

namespace Roto;

require('lib/git.php');

$repo_path = Service::CFG()->repo['root'].$this->param('repo').'/';

$per_page = 20;

$commit_count = getCommitCount($repo_path, $this->param('branch'));

$View->page = (int)$this->param('page');
$View->total_pages = ceil($commit_count / $per_page);

$View->logs = getLogs($repo_path, $this->param('branch'), $View->page * $per_page, $per_page);

$View->repo_root = sprintf("/%s/%s/", $this->param('repo'), $this->param('branch'));
$View->repo = $this->param('repo');

$repo_path = Service::CFG()->repo['root'].$this->param('repo').'/';

$View->branchSwitcher = \Roto\Widget::BranchSwitcher(array(
	'id' => 'branchSwitcher',
	'repo' => $View->repo,
	'current_branch' => $this->param('branch'),
	'branch_names' => array_keys(getBranchInformation($repo_path, false))
));

$View->breadcrumbs = Widget::Breadcrumbs(array(
	'links' => array(
		array(
			'path' => '/'.$this->param('repo').'/',
			'base' => $this->param('repo')
		),
		array(
			'path' => '/'.$this->param('repo').'/'.$this->param('branch').'/',
			'base' => $this->param('branch')
		),
		array(
			'path' => '',
			'base' => 'View Logs'
		)
	)
));
