<?= $this->breadcrumbs->render()?>
<?php foreach ($this->branch_list as $branch) {
	$log = $branch['log'];
	?>
	<div class="panel">
		<div class="panel_date"><?= mydate($log['timestamp']) ?></div>
		<div class="panel_title">
			<a href="/<?= $this->repo_name.'/'.$branch['title'] ?>/">
				<?= $branch['title'] ?>
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
		<div class="panel_content">
			<?= nl2br(htmlentities(join("\n", $log['message']))) ?>
		</div>
		<?php if (isset($log['commit'])) { ?>
		<div class="panel_note">
			SHA1: <?= $log['commit'] ?>
		</div>
		<?php } ?>
		<div class="clearing"></div>
	</div>
<?php } ?>
