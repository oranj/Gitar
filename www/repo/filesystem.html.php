<?php

namespace Roto;


$paths = explode("/", sprintf("%s/%s/%s", $this->repo, $this->branch, $this->file_path));
$running_path = '';
$breadcrumbs = array();
$last = count($paths) -1;
foreach ($paths as $i => $path) {
	$running_path .= $path;
	if ($i !== $last) {
		$running_path .= '/';
	}
	$breadcrumbs []= array(
		'path' => '/repo/'.$running_path,
		'base' => $path
	);
}

if (isset($_GET['raw'])) {
	Service::Router()->setTemplate(false);
}

?>

<div class="panel">
	<h2><?php
		$first = true;
		foreach ($breadcrumbs as $crumb) {
			if (! $first) { echo '/'; }
			$first = false;

			echo '<a href="'.$crumb['path'].'">'.$crumb['base'].'</a>';
		} ?></h2><?php
	if ($this->is_file) { ?>
		<code>
<?= htmlentities($this->file_contents) ?>
		</code>
	<?php } else { ?>
	<table class="file_list">
		<?php foreach ($this->dir_contents as $path) {
			$url = sprintf(
				"/repo/%s/%s/%s%s",
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
	<?php } ?>
</div>