<select id="<?= $this->id ?>" data-repo="<?= $this->repo ?>" data-branch-switcher="<?= $this->id ?>">
<?php foreach ($this->branch_names as $branch) { 
	if ($this->current_branch == $branch) { ?>
	<option selected="selected" value="<?= htmlentities($branch) ?>">Current Branch: <?= htmlentities($branch) ?></option>
	<?php } else { ?>
	<option value="<?= htmlentities($branch) ?>"><?= htmlentities($branch) ?></option>
	<?php } ?>
<?php } ?>
</select>
