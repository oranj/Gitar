<?= $this->breadcrumbs->render()?>
<?php if ($this->is_root) { ?>
<div class="nav">
	<ul>
		<li>
			<a href="/<?= $this->repo ?>/<?= $this->branch ?>/:logs">View Logs</a>
		</li>
	</ul>
	<div class="clearing"></div>
</div>
<?php } ?>
<div class="panel">

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
				<td style="width:100%"><a href="<?= $url ?>"><?= $path ?></td>
			</tr>
		<?php } ?>
	</table>
</div>

<?php if ($this->readme) {
	echo $this->readme->render();

}?>
