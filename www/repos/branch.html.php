<h1>Branches: <em><?= $this->repo_name ?></em></h1>
<?php foreach ($this->branch_list as $branch) { ?>
	<div class="panel">
		<div class="last_commit"><?= mydate($branch['date']) ?></div>
		<div class="panel_title">
			<a href="/repos/<?= $this->repo_name.'/'.$branch['title'] ?>/">
				<?= $branch['title'] ?>
			</a>
		</div>
		<div class="commit"><?= nl2br($branch['log']) ?></div>
	</div>
<?php } ?>
