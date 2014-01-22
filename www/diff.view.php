<?php

$contents = str_replace("\t", "    ", htmlentities($this->file_contents));
$contents = str_replace(" ", "&nbsp;", $contents);
$lines = explode("\n", $this->file_contents);
$is_binary = $this->is_binary;

$diff = $this->diff;
?>
<?php if ($this->is_binary) { ?>
<h2>Binar file differs</h2>
	<?php if ($this->is_img) { ?>
		<img src="<?= sprintf("%s%s:%s", $this->branch_url, $this->file_path, 'raw') ?>" style="max-width: 100%" />
	<?php } ?>
<?php } else { ?>
<table class="codeblock">
<?php
$line_no = 1;
$old_line_no = 1;
$skip = 0;


foreach ($lines as $line) {

	while (true && current($diff)) {
		$diffline = current($diff);
		if ($diffline['newlineno'] == $line_no) {
			if ($diffline['status'] == 'add') { ?>
	<tr>
		<td class="line_no"><?= $line_no ?></td>
		<td class="old_line_no"></td>
		<td class="line add"><?= htmlentities($diffline['line']) ?></td>
	</tr> <?php
				$line_no ++;
				$skip++;
			}
		}
		if ($diffline['oldlineno'] == $old_line_no) {
			if ($diffline['status'] == 'remove') { ?>
	<tr>
		<td class="line_no"></td>
		<td class="old_line_no"><?= $old_line_no ?></td>
		<td class="line remove"><?= htmlentities($diffline['line']) ?></td>
	</tr> <?php
				$old_line_no++;
			}
		} else {
			break;
		}
		next($diff);
	}
	if ($skip <= 0) {
?>
	<tr>
		<td class="line_no"><?= $line_no ?></td>
		<td class="old_line_no"><?= $old_line_no ?></td>
		<td class="line"><?= htmlentities($line) ?></td>
	</tr><?php
		$line_no++;
		$old_line_no++;
	} else {
		$skip--;
	}
}

?>
</table>
<?php } ?>
