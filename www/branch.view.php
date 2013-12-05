<?= $this->breadcrumbs->render()?>
<?php foreach ($this->branch_list as $branch) { ?>
	<div class="panel">
		<div class="panel_date"><?= mydate($branch['log']['timestamp']) ?></div>
		<div class="panel_title">
			<a href="/<?= $this->repo_name.'/'.$branch['title'] ?>/">
				<?= $branch['title'] ?>
			</a>
		</div>
		<div class="commit"><?= nl2br(join("\n", $branch['log']['data'])) ?></div>
	</div>
<?php } ?>
