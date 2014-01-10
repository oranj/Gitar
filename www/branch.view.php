<?= $this->breadcrumbs->render()?>
<div class="nav">
	<ul>
		<li>
			<select id="sortby">
				<option value="title" order="asc">Sort By Title</option>
				<option value="date" selected="selected">Sort By Last Modified</option>
			</select>
		</li>
	</ul>
	<div class="clearing"></div>
</div>

<div class="sortcontainer">
<?php foreach ($this->branch_list as $branch) {
	$log = $branch['log'];
	?>
	<div class="sortable panel"
		data-date="<?= $log['timestamp'] ?>"
		data-title="<?= $branch['title'] ?>">
		<div class="panel_date"><?= mydate($log['timestamp']) ?></div>
		<div class="panel_title">
			<a href="/<?= $this->repo_name.'/'.$branch['title'] ?>/">
				<?= $branch['title'] ?>
			</a>
		</div>
		<?php if ($log['author_gravatar']) { ?>
		<div class="panel_image">
			<img src="http://www.gravatar.com/avatar/<?= $log['author_gravatar'] ?>?s=60&amp;d=mm&amp;r=pg" />
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
</div>
