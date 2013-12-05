<div class="nav">
	<ul>
<?php
$labels = array(
	'md' => 'View as Markdown',
	'html' => 'View as HTML',
	'raw' => 'View Raw'
);
foreach ($this->available_views as $view) {
	$link = sprintf("/%s/%s/%s:%s", $this->repo, $this->branch, $this->file_path, $view);
?>
		<li><a href="<?= $link ?>"><?= $labels[$view] ?></a></li>
<?php } ?>
	</ul>
	<div class="clearing"></div>
</div>
<div class="panel">
	<h2><?= $this->breadcrumbs->render()?></h2>
	<code><?= htmlentities($this->file_contents) ?></code>
</div>
