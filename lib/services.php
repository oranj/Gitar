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
			'request' => '/index.html'
		))
		->map('/^\/(?P<base>.*)\.(?P<extension>[a-z]{1,5})$/', array(
			'controller' => "@{base}.php",
			'view' => "@{base}.@{extension}.php"
		))
		->map('/^\/repos\/(?P<reponame>[^\/]*)\/?$/', array(
			'controller' => 'repos/branch.php',
			'view' => 'repos/branch.html.php',
			'parameters' => array(
				'repo' => '@reponame'
			)
		))
		->map('/^\/repos\/(?P<reponame>[^\/]*)\/(?P<branch>[^\/]+?)\/?\:logs(\/(?P<page>[0-9]+))?$/', array(
			'controller' => 'repos/logs.php',
			'view' => 'repos/logs.html.php',
			'parameters' => array(
				'page' => '@page',
				'repo' => '@reponame',
				'branch' => '@branch'
			),
			'final' => 'true'
		))
		->map('/^\/repos\/(?P<reponame>[^\/]+?)\/(?P<branch>[^\/]+?)\/(?P<path>[^\:]*?)(\:(?P<view>.*?))?$/', array(
			'controller' => 'repos/filesystem.php',
			'view' => 'repos/filesystem.html.php',
			'parameters' => array(
				'view' => '@view',
				'branch' => '@branch',
				'repo' => '@reponame',
				'filepath' => '@path'
			)
		));

	return $router;
});
