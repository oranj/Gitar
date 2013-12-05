<?php

namespace Roto;


$View->repo = $repo = $this->param('repo');
$View->branch = $branch = $this->param('branch');
$View->repo_path = $repo_path = Service::CFG()->repo['root'].$repo.'/';
$View->file_path = $this->param('filepath');

$file_path = $View->file_path ?: "";
$View->is_file = $file_path && ($file_path[strlen($file_path)-1] !== '/');
$View->is_root = $file_path == "";


$paths = array_filter(explode("/", sprintf("%s/%s/%s", $repo, $branch, $file_path)));

$running_path = '';
$breadcrumb_links = array();

$last = count($paths) - 1;
foreach ($paths as $i => $path) {
	$running_path .= $path;
	if ($i !== $last) {
		$running_path .= '/';
	}
	$breadcrumb_links []= array(
		'path' => '/'.$running_path,
		'base' => $path
	);
}


$View->breadcrumbs = \Roto\Widget::Breadcrumbs(array(
	'links' => $breadcrumb_links
));

if (file_exists($repo_path) && is_dir($repo_path)) {
	chdir($repo_path);
	$out = shell_exec($cmd = "git show $branch:$file_path");
	$View->file_contents = $out;
	if ($View->is_file) {

		$available_views = array('raw');
		if (preg_match('/\.(?P<ext>[a-z]{1,5})$/', $file_path, $matches)) {
			switch(strtolower($matches['ext'])) {
				case 'md':
					$available_views []= 'md';
					break;
				case 'html':
				case 'htm':
					$available_views []= 'html';
					break;
			}
		}
		$View->available_views = $available_views;
		$this->template('file.template.php');

		switch ($this->param('view')) {
			case 'framemd':
				$this->view('md.view.php');
				break;
			case 'md':
				$this->template('headless.template.php');
				$this->view('md.view.php');
				break;
			case 'raw':
				$this->template(false);
				$this->view('raw.view.php');
				break;
			case 'framehtml':
				$this->view('html.view.php');
				break;
			case 'html':
				$this->template(false);
				$this->view('html.view.php');
				break;
			default:

				$this->view('file.view.php');
				break;
		}

	} else {
		$this->view('folder.view.php');

		$contents = array_filter(array_slice(explode("\n", $out), 1));

		$View->dir_contents = $contents;
		if ($file_path == "") {
			foreach ($contents as $path) {
				if (preg_match('/readme(?P<ext>\.[a-z]+)?/', strtolower($path), $matches)) {
					$View->readme = \Roto\Widget::Readme(array(
						'is_markdown' => (isset($matches['ext']) && (strtolower($matches['ext']) == '.md')),
						'contents' => shell_exec("git show $branch:$path")
					));
					break;
				}
			}
		}
	}
}
