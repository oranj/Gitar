<?= $this->breadcrumbs->render()?>
<div class="nav">
	<ul>
		<li class="nav_link">
			<a href="<?= $this->branch_url ?>:logs">View Logs</a>
		</li>
		<li class="nav_selector">
			<?= $this->branchSwitcher->render() ?>
		</li>
	</ul>
	<div class="clearing"></div>
	
</div>
<div class="panel">
	<div class="panel_title">Filesystem</div>
	<table class="file_list">
		<?php foreach ($this->dir_contents as $path) {

			$url = sprintf(
				"/%s/%s/%s%s",
				$this->repo,
				$this->branch,
				$this->file_path,
				$path
			);

			$is_dir = $path[strlen($path)-1] == '/';
			?>
			<tr>
				<td>
				<?php if ($is_dir){ ?>
					<div class="iconic folder_stroke"></div>
				<?php } ?>
				</td>
				<td style="width:100%"><a href="<?= $url ?>"><?= $path ?></a></td>
			</tr>
		<?php } ?>
	</table>
</div>

<?php if ($this->readme) {
	echo $this->readme->render();
}?>

<?php if ($this->modified_files) { ?>
<div class="panel">
	<div class="panel_title">
		Modified Files
	</div>
	<table class="file_list">
	<?php foreach ($this->modified_files as $filename) {
		$url = sprintf("%s%s:commit", $this->branch_url, $filename);
	?>
		<tr>
			<td></td>
			<td style="width:100%"><a href="<?= $url ?>"><?= $filename ?></a></td>
		</tr>
	<?php } ?>
	</table>
</div>
<?php }
