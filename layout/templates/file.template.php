<?php

namespace Roto;

$title = makeTitle();

$labels = array(
	'md' => 'View as Markdown',
	'html' => 'View as HTML',
	'raw' => 'View Raw',
	'img' => 'View Image',
);
$links = array();
foreach ($View->available_views as $view) {
	$links[$view] = sprintf("%s%s:%s", $View->branch_url, $View->file_path, $view);
}

?>

<!DOCTYPE html>
<!--
<?= Widget::RouteInfo(array(
	'trace' => Service::Router()->routingData()
))->render(); ?>-->
<html>
	<head>
		<link href="/css/main.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Trade+Winds' rel='stylesheet' type='text/css'>
		<link href="/icon/iconic_stroke.css" rel="stylesheet" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript"  src="/js/site.js"></script>
		<title><?= strip_tags($title) ?></title>
		<meta name="viewport" content="width=device-width, user-scalable=no" />
	</head>
	<body class="workDesk">
		<div class="header">
			<div class="header-inner">
				<a class="title" href="/"><?= $title ?></a>
				<div class="clearing"></div>
			</div>
		</div>
		<div class="stage">
			<div class="content">
				<div class="breadcrumbs">
					<?= $View->breadcrumbs->render() ?>
				</div>
				<div class="nav">
					<ul>
<?php foreach ($links as $view => $link) { ?>
						<li class="nav_link"><a href="<?= $link ?>"><?= isset($labels[$view]) ? $labels[$view] : 'View as ' . $view ?></a></li>
<?php } ?>
					</ul>
					<div class="clearing"></div>
				</div>
				<div class="panel">
					<?= $View->main() ?>
					<div class="clearing"></div>
				</div>
			</div>
		</div>
		<div id="footer_icon"></div>
	</body>
</html>
