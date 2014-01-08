<?php

$contents = str_replace("\t", "    ", htmlentities($this->file_contents));
$contents = str_replace(" ", "&nbsp;", $contents);
$lines = explode("\n", $this->file_contents);


$diff = $this->diff;
?>

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
