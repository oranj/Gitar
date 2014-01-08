<?php

$lines = explode("\n", $this->file_contents);
$lines = array_map('htmlentities', $lines);

?>
<table class="codeblock">
<?php foreach ($lines as $i => $line) { ?>
	<tr>
		<td class="line_no"><?= $i + 1 ?></td>
		<td class="line"><?= $line ?></td>
	</tr>
<?php } ?>
</table>
