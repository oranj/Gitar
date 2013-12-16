<?php

namespace Roto;

$root = dirname(dirname(__FILE__));

Service::register('CFG', function() use ($root) {
	return new Config(
		$root.'/config/config.ini',
		$root.'/config/config.default.ini'
	);
});

Service::register('View', function() {
	return new View();
});

Service::register('Router', function() use ($root) {
	$router = new Router(
		Service::View(),
		$root . '/www/',
		$root . '/layout/templates/',
		'_folder.php'
	);

	$router
		->map('/.*/', array(
			'template' => 'html.template.php'
		))
		->map('/^\/$/', array(
			'controller' => 'repos.controller.php',
			'view' => 'repos.view.php',
			'final' => 'true'
		))
		->map('/^\/(?P<reponame>[^\/]*)\/?(\:(?P<option>.*?))?$/', array(
			'controller' => 'branch.controller.php',
			'view' => 'branch.view.php',
			'parameters' => array(
				'option' => '@option',
				'repo' => '@reponame'
			)
		))
		->map('/^\/(?P<reponame>[^\/]*)\/(?P<branch>[^\/]+?)\/?\:logs(\/(?P<page>[0-9]+))?$/', array(
			'controller' => 'logs.controller.php',
			'view' => 'logs.view.php',
			'parameters' => array(
				'page' => '@page',
				'repo' => '@reponame',
				'branch' => '@branch'
			),
			'final' => 'true'
		))
		->map('/^\/(?P<reponame>[^\/]+?)\/(?P<branch>[^\/]+?)\/(?P<path>[^\:]*?)(\:(?P<view>.*?))?$/', array(
			'controller' => 'filesystem.controller.php',
			'parameters' => array(
				'view' => '@view',
				'branch' => '@branch',
				'repo' => '@reponame',
				'filepath' => '@path'
			)
		));

	return $router;
});
