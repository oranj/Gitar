<?php

namespace Roto;

require('lib/git.php');

$repo_path = Service::CFG()->repo['root'].$this->param('repo').'/';

$per_page = 20;

$View->page = (int)$this->param('page');

$View->logs = getLogs($repo_path, $this->param('branch'), $View->page * $per_page, $per_page);
$View->repo_root = sprintf("/repos/%s/%s/", $this->param('repo'), $this->param('branch'));