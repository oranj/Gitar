<?php
$title = makeTitle();
?>

<!DOCTYPE html>
<!--
<?php print_r(\Roto\Service::Router()->routingData()) ?>

-->
<html>
	<head>
		<link href="/css/main.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Trade+Winds' rel='stylesheet' type='text/css'>
		<link href="/icon/iconic_stroke.css" rel="stylesheet" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript"  href="/js/site.js"></script>
		<title><?= strip_tags($title) ?></title>
	</head>
	<body class="workDesk">
		<div class="header">
			<?php /*
			<div class="nav">
				<audio preload loop id="metalaudio">
					<source src="res/guitar.mp3" type="audio/mpeg">
				</audio>
				<select id="sortby">
					<option value="title" order="asc">Sort By Title</option>
					<option value="date">Sort By Last Modified</option>
				</select>
				<input type="text" id="filter" data-smartdefault="Filter..." />
			</div>*/ ?>
			<a class="title" href="/"><?= $title ?></a>
			<div class="clearing"></div>
		</div>
		<div class="stage">
			<div class="content">
				<?= $View->main() ?>
			</div>
		</div>
	</body>
</html>