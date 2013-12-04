<div class="panel">
	<h2><?= $this->repo_name ?>: Branches</h2>
	<ul class="selection categories">
	<?php foreach ($this->branch_list as $branch) { ?>
		<li><a class="btn" href="/repos/<?= $this->repo_name.'/'.$branch ?>/"><?= $branch ?></a></li>
	<?php } ?>
	</ul>
</div>
