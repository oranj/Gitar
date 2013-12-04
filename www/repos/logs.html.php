<div class="nav">
	<ul>
		<?php if ($this->page > 0) {?>
		<li><a href="<?= $this->repo_root ?>:logs/<?= $this->page - 1 ?>">Later Logs</a></li>
		<?php } ?>
		<li><a href="<?= $this->repo_root ?>:logs/<?= $this->page + 1 ?>">Earlier Logs</a></li>
		<li><a href="<?= $this->repo_root ?>">View Filesystem</a></li>

	</ul>
	<div class="clearing"></div>
</div>
<?php foreach ($this->logs as $log) {
	$has_email = false;
	$author = (isset($log['Author']) ? $log['Author'] : '');
	if (isset($log['Author']) && preg_match('/^(?P<author>.+?) \<(?P<email>.+)\>$/', $log['Author'], $matches)) {
		$has_email = true;
		$author = $matches['author'];
		$gravatar_hash = md5(strtolower(trim($matches['email'])));
	}

?>
<div class="panel">
	<div class="last_commit"><?= $log['Date'] ?></div>
	<div class="panel_title">
		<?= $log['commit'] ?>
	</div>
	<?php if ($has_email) { ?>
	<div class="panel_image">
			<img src="http://www.gravatar.com/avatar/<?= $gravatar_hash ?>?s=60&amp;d=identicon&amp;r=pg" />
		<?php } ?>
	</div>
	<div class="panel_author">
		<?= $author ?>
	</div>
	<div class="panel_content"><?= join(" ", $log['message']) ?></div>
	<div class="clearing"></div>
</div>
<?php } ?>