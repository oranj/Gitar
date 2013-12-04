<?php
$title = makeTitle();
header('Content-Type: text/html; charset=UTF-8');
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
		<script type="text/javascript"  src="/js/site.js"></script>
		<title><?= strip_tags($title) ?></title>
	</head>
	<body class="workDesk">
		<div class="stage">
			<div class="content">
				<?= $View->main() ?>
			</div>
		</div>
	</body>
</html>