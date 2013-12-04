<div class="panel">
	<h2><?= $this->breadcrumbs->render()?></h2>
	<table class="file_list">
		<?php foreach ($this->dir_contents as $path) {

			$url = sprintf(
				"/repos/%s/%s/%s%s",
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