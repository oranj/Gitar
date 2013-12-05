<div class="nav">
	<ul>
		<?php if ($this->page > 0) {?>
		<li><a href="<?= $this->repo_root ?>:logs/<?= $this->page - 1 ?>">&laquo; Later Logs</a></li>
		<?php } ?>
		<li><a href="<?= $this->repo_root ?>:logs/<?= $this->page + 1 ?>">Earlier Logs &raquo;</a></li>
		<li><a href="<?= $this->repo_root ?>">View Filesystem</a></li>

	</ul>
	<div class="clearing"></div>
</div>
<?php foreach ($this->logs as $log){ ?>
<div class="panel">
	<div class="panel_date"><?= $log['Date'] ?></div>
	<div class="panel_title">
		<?= $log['commit'] ?>
	</div>
	<?php if ($log['author_gravatar']) { ?>
	<div class="panel_image">
		<img src="http://www.gravatar.com/avatar/<?= $log['author_gravatar'] ?>?s=60&amp;d=identicon&amp;r=pg" />
	</div>
	<?php } ?>
	<div class="panel_author">
		<?= $log['author_name'] ?>
	</div>
	<div class="panel_content"><?= join(" ", $log['message']) ?></div>
	<div class="clearing"></div>
</div>
<?php } ?>