<?= $this->breadcrumbs->render() ?>
<div class="nav">
	<ul>
		<?php if ($this->page > 0) {?>
		<li class="nav_link"><a href="<?= $this->repo_root ?>:logs/<?= $this->page - 1 ?>">&laquo; Later Logs</a></li>
<?php } /* not else */ if ($this->page < $this->total_pages-1) { ?>
		<li class="nav_link"><a href="<?= $this->repo_root ?>:logs/<?= $this->page + 1 ?>">Earlier Logs &raquo;</a></li>
<?php } ?>

		<li class="nav_link"><a href="<?= $this->repo_root ?>">View Filesystem</a></li>

	</ul>
	<div class="clearing"></div>
</div>
<?php foreach ($this->logs as $log){ ?>
<div class="panel">
	<div class="panel_date"><?= $log['Date'] ?></div>
	<div class="panel_title">
		<a href="/<?= $this->repo ?>/$<?= $log['commit'] ?>/">
			<?= $log['commit'] ?>
		</a>
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
<div class="nav">
	<ul>
<?php if ($this->page > 0) {?>
		<li class="nav_link"><a href="<?= $this->repo_root ?>:logs/<?= $this->page - 1 ?>">&laquo; Later Logs</a></li>
<?php } /* not else */ if ($this->page < $this->total_pages-1) { ?>
		<li class="nav_link"><a href="<?= $this->repo_root ?>:logs/<?= $this->page + 1 ?>">Earlier Logs &raquo;</a></li>
<?php } ?>
		<li class="nav_link"><a href="<?= $this->repo_root ?>">View Filesystem</a></li>

	</ul>
	<div class="clearing"></div>
</div>